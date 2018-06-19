<?php

namespace FederalSt;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class Vehicle extends Model
{
    protected $table='vehicles';

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
        'model',
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
