<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemberResource\Pages;
use App\Models\Pages\Member;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Organisasi';
    protected static ?string $navigationGroup = 'Manajemen Konten';

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\FileUpload::make('photo')
                ->image()
                ->directory('members')
                ->disk('public')
                ->imageResizeMode('cover')
                ->imageResizeTargetWidth(400)
                ->imageResizeTargetHeight(400)
                ->required(),

            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),

            Forms\Components\Select::make('position')
                ->required()
                ->searchable(),

            Forms\Components\Select::make('division')
                ->required()
                ->searchable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) =>
                $query->select(['id','photo','name','position','division','created_at'])
            )
            ->defaultSort('created_at', 'desc')
            ->paginated([10])
            ->columns([

                Tables\Columns\ImageColumn::make('photo')
                    ->disk('public')
                    ->height(50)
                    ->width(50),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('position')
                    ->sortable(),

                Tables\Columns\TextColumn::make('division')
                    ->sortable()
                    ->searchable(),

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
            'index' => Pages\ListMembers::route('/'),
            'create' => Pages\CreateMember::route('/create'),
            'edit' => Pages\EditMember::route('/{record}/edit'),
        ];
    }
}
