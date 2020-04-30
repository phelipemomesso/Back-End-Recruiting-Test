<?php
/**
 * @OA\Schema(
 *     schema="product_products",
 *     description="Product model",
 *     type="object",
 *     title="Product model",
 *     allOf={
 *         @OA\Schema(
 *             required={"place_id", "category_id", "name", "value"},
 *
 *              @OA\Property(
 *                 readOnly=true,
 *                 property="id",
 *                 description="ID of the product",
 *                 type="integer",
 *                 format="int64",
 *             ),
 *
 *             @OA\Property(
 *                 readOnly=true,
 *                 property="place_id",
 *                 description="Place of the product",
 *                 type="integer",
 *                 format="int64",
 *             ),
 *
 *             @OA\Property(
 *                 readOnly=true,
 *                 property="category_id",
 *                 description="Category of the product",
 *                 type="integer",
 *                 format="int64",
 *             ),
 *
 *             @OA\Property(
 *                 property="name",
 *                 type="string",
 *                 description="Name of the product",
 *                 maxLength=150,
 *             ),
 *
 *             @OA\Property(
 *                 property="value",
 *                 description="Value of the product",
 *                 type="number",
 *                 format="float"
 *             ),
 *
 *             @OA\Property(
 *                 property="is_active",
 *                 description="Status of the product",
 *                 type="boolean",
 *                 default=true,
 *             ),
 *
 *             @OA\Property(
 *                 readOnly=true,
 *                 property="created_at",
 *                 description="When the product was created",
 *                 type="string",
 *                 format="date-time",
 *             ),
 *
 *             @OA\Property(
 *                 readOnly=true,
 *                 property="updated_at",
 *                 description="When the product was last updated",
 *                 type="string",
 *                 format="date-time",
 *             ),
 *         ),
 *     }
 * )
 */
