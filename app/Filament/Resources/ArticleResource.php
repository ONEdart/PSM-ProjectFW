<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Pages\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Artikel';
    protected static ?string $navigationGroup = 'Manajemen Konten';

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\TextInput::make('title')
                ->required()
                ->lazy() // lebih ringan dari live
                ->afterStateUpdated(
                    fn($state, callable $set) =>
                    $set('slug', Str::slug($state))
                ),

            Forms\Components\TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true),

            Forms\Components\FileUpload::make('thumbnail')
                ->image()
                ->directory('articles')
                ->disk('public')
                ->imageResizeMode('cover')
                ->imageResizeTargetWidth(600)
                ->imageResizeTargetHeight(600),

            Forms\Components\Textarea::make('excerpt')
                ->rows(3)
                ->maxLength(200),

            Forms\Components\RichEditor::make('content')
                ->required()
                ->columnSpanFull()
                ->disableToolbarButtons([
                    'attachFiles', // kurangi fitur berat
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) =>
                $query->select(['id','title','thumbnail','created_at'])
            )
            ->defaultSort('created_at', 'desc')
            ->paginated([10])
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->disk('public')
                    ->height(50)
                    ->width(50),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    protected static function mutateFormDataBeforeCreate(array $data): array
    {
        $data['excerpt'] = Str::limit(strip_tags($data['content']), 150);
        return $data;
    }

    protected static function mutateFormDataBeforeSave(array $data): array
    {
        $data['excerpt'] = Str::limit(strip_tags($data['content']), 150);
        return $data;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
