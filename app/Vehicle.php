<?php

namespace FederalSt;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

/**
 * FederalSt\Vehicle
 *
 * @property int $id
 * @property int $owner_id
 * @property string $plate
 * @property string $brand
 * @property string $vehicle_model
 * @property string $year
 * @property string $renavam
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \FederalSt\User $owner
 * @method static \Illuminate\Database\Eloquent\Builder|\FederalSt\Vehicle whereBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\FederalSt\Vehicle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\FederalSt\Vehicle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\FederalSt\Vehicle whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\FederalSt\Vehicle wherePlate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\FederalSt\Vehicle whereRenavam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\FederalSt\Vehicle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\FederalSt\Vehicle whereVehicleModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\FederalSt\Vehicle whereYear($value)
 * @mixin \Eloquent
 */
class Vehicle extends Model
{
    use Eloquence;

    protected $table='vehicles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'owner_id', 'plate', 'brand', 'year','vehicle_model', 'renavam'
    ];

    /**
     * Este é um array que será utilizado pelo Eloquent para fazer pesquisas
     * em diversas colunas do Banco ao mesmo tempo. Facilitanto assim algumas pesquisas
     * que precisariam de várias linhas de código para serem expressadas.
     *
     * @var array
     */
    protected $searchableColumns = [
        'plate',
        'brand',
        'vehicle_model',
        'year',
        'renavam'
    ];


    /*
     * As relações apresentadas a baixo são as mesmas que a table vinculada a esta classe tem
     * no Banco de Dados. Elas serão separadas etre Pertence, são aquelas que a chave estrangeira
     * está dentro da tabela, e Possui, são aquelas que em outra tabela existe uma ou mais
     * instancias dos elementos da tabela relacionada com essa classe.
     * */

    //Relações que Pertence

    public function owner()
    {
        return $this->belongsTo('FederalSt\User', 'owner_id', 'id');
    }
}
