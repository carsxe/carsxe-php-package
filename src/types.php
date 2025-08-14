<?php

namespace CarsxeDeveloper\Carsxe;

/**
 * Defines the parameter structure for each endpoint in the CarsXE API.
 * These dictionaries specify the required and optional parameters.
 * 
 * @author omar-walied
 * @date 2025-08-14
 */

class Types
{
    public const VinInput = [
        'vin' => 'string', // Required - Vehicle Identification Number
    ];

    public const PlateDecoderParams = [
        'plate' => 'string', // Required - License plate number
        'country' => 'string', // Required - Country code (e.g., US, PK)
        'state' => 'optional', // Optional - State/Province
        'district' => 'optional', // Optional - District (required for PK)
    ];

    public const ImageInput = [
        'make' => 'string', // Required - Vehicle make
        'model' => 'string', // Required - Vehicle model
        'year' => 'optional', // Optional - Vehicle year
        'trim' => 'optional', // Optional - Vehicle trim
        'color' => 'optional', // Optional - Vehicle color
        'transparent' => 'optional', // Optional - Transparent background
        'angle' => 'optional', // Optional - Image angle
        'photoType' => 'optional', // Optional - Photo type
        'size' => 'optional', // Optional - Image size
        'license' => 'optional', // Optional - License type
    ];

    public const ObdcodesdecoderInput = [
        'code' => 'string', // Required - OBD error code
    ];

    public const PlateImageRecognitionInput = [
        'upload_url' => 'string', // Required - Image URL for plate recognition
    ];

    public const VinOcrInput = [
        'upload_url' => 'string', // Required - Image URL for VIN OCR
    ];

    public const YearMakeModelInput = [
        'year' => 'string', // Required - Vehicle year
        'make' => 'string', // Required - Vehicle make
        'model' => 'string', // Required - Vehicle model
        'trim' => 'optional', // Optional - Vehicle trim
    ];

    public const SpecsInput = [
        'vin' => 'string', // Required - Vehicle Identification Number
        'deepData' => 'optional', // Optional - Enable deep data retrieval
        'disableIntVINDecoding' => 'optional', // Optional - Disable international VIN decoding
    ];

    /**
     * Get required and optional parameters for a given endpoint type
     * 
     * @param array $paramDefinition
     * @return array [required, optional]
     */
    public static function getRequiredOptional(array $paramDefinition): array
    {
        $required = [];
        $optional = [];

        foreach ($paramDefinition as $param => $type) {
            if ($type === 'optional') {
                $optional[] = $param;
            } else {
                $required[] = $param;
            }
        }

        return [$required, $optional];
    }

    /**
     * Validate parameters against a parameter definition
     * 
     * @param array $params
     * @param array $paramDefinition
     * @throws \Exception
     */
    public static function validateParams(array $params, array $paramDefinition): void
    {
        [$required, $optional] = self::getRequiredOptional($paramDefinition);

        foreach ($required as $param) {
            if (!isset($params[$param]) || $params[$param] === null || $params[$param] === '') {
                throw new \Exception("Missing required parameter: $param");
            }
        }
    }
}