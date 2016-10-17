<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\DirectorBankDetails
 *
 * @property integer $id
 * @property string $account_owner
 * @property string $account_number
 * @property string $bank_code
 * @property string $bank_name
 * @property string $iban
 * @property string $bic
 * @property string $firm_name
 * @property string $first_last_name
 * @property string $post_index
 * @property string $street
 * @property string $addition_address
 * @property string $logo
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorBankDetails whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorBankDetails whereAccountOwner($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorBankDetails whereAccountNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorBankDetails whereBankCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorBankDetails whereBankName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorBankDetails whereIban($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorBankDetails whereBic($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorBankDetails whereFirmName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorBankDetails whereFirstLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorBankDetails wherePostIndex($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorBankDetails whereStreet($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorBankDetails whereAdditionAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorBankDetails whereLogo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorBankDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorBankDetails whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $ust_id
 * @property string $trade_register
 * @property string $tax_number
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorBankDetails whereUstId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorBankDetails whereTradeRegister($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectorBankDetails whereTaxNumber($value)
 */
class DirectorBankDetails extends Model
{
    protected $table = 'director_bank_details';
    protected $fillable = ['account_owner', 'account_number', 'bank_code', 'bank_name', 
                        'iban', 'bic', 'ust_id', 'trade_register', 'tax_number', 'firm_name', 'first_last_name',
                        'post_index', 'street', 'addition_address', 'logo'];
    
}
