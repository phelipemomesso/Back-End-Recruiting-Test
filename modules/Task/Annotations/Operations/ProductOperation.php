<?php

/**
 * @OA\Tag(
 *     name="product/products",
 *     description="Operations about products",
 * )
 */

/**
 * @OA\Get(
 *     path="/product/place/{place}/products",
 *     tags={"product/products"},
 *     summary="Display a listing of the products",
 *     operationId="index",
 *     security={
 *         {"passport": {}},
 *     },
 *
 *     @OA\Parameter(ref="#/components/parameters/product_place_required"),
 *
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/product_products")
 *         ),
 *     ),
 *
 *     @OA\Response(
 *         response=400,
 *         description="Bad Request",
 *         @OA\JsonContent()
 *     ),
 *
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent()
 *     ),
 *
 *     @OA\Response(
 *         response=404,
 *         description="Not Found",
 *         @OA\JsonContent(),
 *     ),
 * )
 */

/**
 * @OA\Get(
 *     path="/product/place/{place}/products/{product}",
 *     tags={"product/products"},
 *     summary="Display the specified product",
 *     operationId="show",
 *     security={
 *         {"passport": {}},
 *     },
 *
 *     @OA\Parameter(ref="#/components/parameters/product_place_required"),
 *     @OA\Parameter(ref="#/components/parameters/product_products_required"),
 *
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(ref="#/components/schemas/product_products"),
 *     ),
 *
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(),
 *     ),
 *
 *     @OA\Response(
 *         response=404,
 *         description="Not Found",
 *         @OA\JsonContent(),
 *     ),
 * )
 */

/**
 * @OA\Post(
 *     path="/product/place/{place}/products",
 *     tags={"product/products"},
 *     summary="Store a newly product in storage",
 *     operationId="store",
 *     security={
 *         {"passport": {}},
 *     },
 *
 *     @OA\Parameter(ref="#/components/parameters/product_place_required"),
 *
 *     @OA\RequestBody(
 *         description="Data to create a category in storage",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/product_products"),
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(ref="#/components/schemas/product_products")
 *         ),
 *     ),
 *
 *     @OA\Response(
 *         response=201,
 *         description="Created",
 *         @OA\JsonContent(ref="#/components/schemas/product_products")
 *     ),
 *
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent()
 *     ),
 *
 *     @OA\Response(
 *         response=422,
 *         description="Unprocessable Entity",
 *         @OA\JsonContent(),
 *     ),
 * )
 */

/**
 * @OA\Put(
 *     path="/product/place/{place}/products/{product}",
 *     tags={"product/products"},
 *     summary="Update the specified product in storage",
 *     operationId="update",
 *     security={
 *         {"passport": {}},
 *     },
 *
 *     @OA\Parameter(ref="#/components/parameters/product_place_required"),
 *     @OA\Parameter(ref="#/components/parameters/product_products_required"),
 *
 *     @OA\RequestBody(
 *         description="Data to update category in storage",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/product_products"),
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(ref="#/components/schemas/product_products")
 *         ),
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(ref="#/components/schemas/product_products"),
 *     ),
 *
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent()
 *     ),
 *
 *     @OA\Response(
 *         response=422,
 *         description="Unprocessable Entity",
 *         @OA\JsonContent(),
 *     ),
 * )
 */

/**
 * @OA\Delete(
 *     path="/product/place/{place}/products/{product}",
 *     tags={"product/products"},
 *     summary="Remove the specified product from storage",
 *     operationId="destroy",
 *     security={
 *         {"passport": {}},
 *     },
 *
 *     @OA\Parameter(ref="#/components/parameters/product_place_required"),
 *     @OA\Parameter(ref="#/components/parameters/product_products_required"),
 *
 *     @OA\Response(
 *         response=204,
 *         description="No Content",
 *         @OA\JsonContent()
 *     ),
 *
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent()
 *     ),
 * )
 */
