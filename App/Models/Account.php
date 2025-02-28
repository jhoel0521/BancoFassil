<?php

namespace App\Models;

use Core\Model;

class Account extends Model
{

    // id INT AUTO_INCREMENT PRIMARY KEY,
    // currentBalance DECIMAL(10, 2) DEFAULT 0.00,
    // type ENUM ('CA', 'CC') NOT NULL COMMENT 'CA: Current Account, CC: Savings Account',
    // status ENUM ('AC', 'IN') DEFAULT 'AC' COMMENT 'AC: Active, IN: Inactive',
    // personId INT NOT NULL,
    // officeId INT NOT NULL,
    // created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    // updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    // FOREIGN KEY (personId) REFERENCES Person (id) ON DELETE CASCADE,
    // FOREIGN KEY (officeId) REFERENCES Office (id) ON DELETE CASCADE
    protected $table = 'Account';
    protected $primaryKey = 'id';
    protected $fillable = ['currentBalance', 'type', 'status', 'personId', 'officeId'];
    protected $timestamps = true;
    public static function types()
    {
        if (getLanguage() == 'es') {
            return [
                'CA' => 'Cuenta Corriente',
                'CC' => 'Cuenta de Ahorro'
            ];
        } elseif (getLanguage() == 'en') {
            return [
                'CA' => 'Current Account',
                'CC' => 'Savings Account'
            ];
        }
    }
}
