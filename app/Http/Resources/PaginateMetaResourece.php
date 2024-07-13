<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginateMetaResourece extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            /**
             * @var int Listenin ilgili sayfasında kaç tane kayıt olduğu bilgisidir
             * @example 1
             */
            "itemCount" => @$this->get("itemCount"),

            /**
             * @var int Listede toplamda çekilebilecek kaç tane kayıt olduğu bilgisidir.
             * @example 1
             */
            "totalItems" => @$this->get("totalItems"),

            /**
             * @var int Listede kaçıncı sayfada olunduğu bilgisidir.
             * @example 1
             */
            "currentPage" => @$this->get("currentPage"),

            /**
             * @var int Listedeki her bir sayfada kaç tane kayıt olduğu bilgisidir.
             * @example 1
             */
            "itemsPerPage" => @$this->get("itemsPerPage"),

            /**
             * @var int Listede çekilebilecek kaç tane sayfa olduğu bilgisidir.
             * @example 1
             */
            "totalPages" => @$this->get("totalPages"),
        ];
    }
}
