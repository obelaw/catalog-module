<?php

namespace Obelaw\Catalog\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Obelaw\Contacts\ContactType;
use Obelaw\Contacts\Models\Contact;

class ContactVendor extends Contact
{
    use HasFactory;

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope('documentType', function (Builder $builder) {
            $builder->where('document_type',  ContactType::get('VENDOR'));
        });
    }
}