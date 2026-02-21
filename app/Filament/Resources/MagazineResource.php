<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MagazineResource\Pages;
use App\Models\Pages\Magazine;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MagazineResource extends Resource
{
    protected static ?string $model = Magazine::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Majalah';
    protected static ?string $navigationGroup = 'Manajemen Konten';

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\TextInput::make('title')
                ->required()
                ->maxLength(255),

            Forms\Components\FileUpload::make('cover')
                ->image()
                ->directory('magazines/covers')
                ->disk('public')
                ->imageResizeMode('cover')
                ->imageResizeTargetWidth(600)
                ->imageResizeTargetHeight(800)
                ->required(),

            Forms\Components\FileUpload::make('file')
                ->label('File Majalah (PDF)')
                ->acceptedFileTypes(['application/pdf'])
                ->directory('magazines/files')
                ->disk('public')
                ->required()
                ->maxSize(20480),

            Forms\Components\RichEditor::make('description')
                ->required()
                ->columnSpanFull()
                ->toolbarButtons([
                    'bold',
                    'italic',
                    'underline',
                    'strike',
                    'bulletList',
                    'orderedList',
                    'h2',
                    'h3',
                    'blockquote',
                    'link',
                    'undo',
                    'redo',
                ])
                ->disableToolbarButtons([
                    'attachFiles',
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(
                fn(Builder $query) =>
                $query->select(['id', 'title', 'cover', 'file', 'created_at'])
            )
            ->defaultSort('created_at', 'desc')
            ->paginated([10])
            ->columns([

                Tables\Columns\ImageColumn::make('cover')
                    ->disk('public')
                    ->height(70)
                    ->width(50),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(40),

                Tables\Columns\TextColumn::make('file')
                    ->label('PDF')
                    ->url(fn($record) => asset('storage/' . $record->file))
                    ->openUrlInNewTab(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMagazines::route('/'),
            'create' => Pages\CreateMagazine::route('/create'),
            'edit' => Pages\EditMagazine::route('/{record}/edit'),
        ];
    }
}
