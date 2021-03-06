<?php

namespace FederalSt;

use FederalSt\Notifications\DestroyVehicleNotification;
use FederalSt\Notifications\MyResetPasswordNotification;
use FederalSt\Notifications\StoreVehicleNotification;
use FederalSt\Notifications\UpdateVehicleNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Sofa\Eloquence\Eloquence;

/**
 * FederalSt\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $role
 * @property string $phone
 * @property string $cpf
 * @property string|null $api_token
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\FederalSt\Vehicle[] $vehicles
 * @method static \Illuminate\Database\Eloquent\Builder|\FederalSt\User whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\FederalSt\User whereCpf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\FederalSt\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\FederalSt\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\FederalSt\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\FederalSt\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\FederalSt\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\FederalSt\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\FederalSt\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\FederalSt\User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\FederalSt\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;
    use Eloquence;
    const ROLE_USER = 1;
    const ROLE_ADMIN = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role','phone', 'cpf'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Este é um array que será utilizado pelo Eloquent para fazer pesquisas
     * em diversas colunas do Banco ao mesmo tempo. Facilitanto assim algumas pesquisas
     * que precisariam de várias linhas de código para serem expressadas.
     *
     * @var array
     */
    protected $searchableColumns = [
        'name',
        'email',
        'phone',
        'cpf'
    ];

    /*
    * As relações apresentadas a baixo são as mesmas que a table vinculada a esta classe tem
    * no Banco de Dados. Elas serão separadas etre Pertence, são aquelas que a chave estrangeira
    * está dentro da tabela, e Possui, são aquelas que em outra tabela existe uma ou mais
    * instancias dos elementos da tabela relacionada com essa classe.
    * */

    //Relações que Possui

    public function vehicles()
    {
        return $this->hasMany('FederalSt\Vehicle', 'owner_id', 'id');
    }

    //Métodos de Autenticação

    public function isAdmin()
    {
        return $this->role === User::ROLE_ADMIN;
    }

    /**
     * Enviando notificação de recuperação de senha.
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MyResetPasswordNotification($token));
    }

    public function sendStoreVehicleNotification(Vehicle $vehicle)
    {
        $this->notify(new StoreVehicleNotification($vehicle));
    }

    public function sendUpdateVehicleNotification(Vehicle $vehicle)
    {
        $this->notify(new UpdateVehicleNotification($vehicle));
    }

    public function sendDestroyVehicleNotification(Vehicle $vehicle)
    {
        $this->notify(new DestroyVehicleNotification($vehicle));
    }
}
