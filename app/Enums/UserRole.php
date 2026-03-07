<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case MANAGER = 'manager';
    case EMPLOYEE = 'employee';
    case CASHIER = 'cashier';
    case CUSTOMER = 'customer';
    case FRANCHISE = 'franchise';

    /**
     * Get the human-readable label for the role in Spanish.
     */
    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrador',
            self::MANAGER => 'Encargado',
            self::EMPLOYEE => 'Empleado',
            self::CASHIER => 'Cajero',
            self::CUSTOMER => 'Cliente',
            self::FRANCHISE => 'Franquicia',
        };
    }
}
