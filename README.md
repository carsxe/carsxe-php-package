# 🚗 CarsXE API (PHP Library)

**CarsXE** is a powerful and developer-friendly API that gives you instant access to a wide range of vehicle data. From VIN decoding and market value estimation to vehicle history, images, OBD code explanations, and plate recognition, CarsXE provides everything you need to build automotive applications at scale.

🌐 **Website:** [https://api.carsxe.com](https://api.carsxe.com)  
📄 **Docs:** [https://api.carsxe.com/docs](https://api.carsxe.com/docs)  
📦 **All Products:** [https://api.carsxe.com/all-products](https://api.carsxe.com/all-products)

---

## Installation

Install the CarsXE PHP library using Composer:

```bash
composer require carsxe/carsxe
```

This will automatically download the library and its dependencies into your project.

---

## Usage

### Initialize the CarsXE Library

To start using the CarsXE API, include Composer's autoloader and create an instance of the `Carsxe` class with your API key:

```php
require_once __DIR__ . '/vendor/autoload.php';
use CarsxeDeveloper\Carsxe\Carsxe;

$API_KEY = 'YOUR_API_KEY';
$carsxe = new Carsxe($API_KEY);
```

### Example: Decode Vehicle Specifications (`specs` Endpoint)

```php
try {
    $vehicle = $carsxe->specs(['vin' => 'WBAFR7C57CC811956']);
    print_r($vehicle);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
```

---

## Endpoints

### `specs` – Decode VIN & get full vehicle specifications

**Required:**

- `vin`

**Optional:**

- `deepdata`
- `disableIntVINDecoding`

**Example:**

```php
$vehicle = $carsxe->specs(['vin' => 'WBAFR7C57CC811956']);
```

---

### `intVinDecoder` – Decode VIN with worldwide support

**Required:**

- `vin`

**Optional:**

- None

**Example:**

```php
$intVin = $carsxe->intVinDecoder(['vin' => 'WF0MXXGBWM8R43240']);
```

---

### `plateDecoder` – Decode license plate info (plate, country)

**Required:**

- `plate`
- `country` (always required except for US, where it is optional and defaults to 'US')

**Optional:**

- `state` (required for some countries, e.g. US, AU, CA)
- `district` (required for Pakistan)

**Example:**

```php
$decodedPlate = $carsxe->plateDecoder(['plate' => '7XER187', 'state' => 'CA', 'country' => 'US']);
```

---

### `marketValue` – Estimate vehicle market value based on VIN

**Required:**

- `vin`

**Optional:**

- `state`

**Example:**

```php
$marketValue = $carsxe->marketValue(['vin' => 'WBAFR7C57CC811956']);
```

---

### `history` – Retrieve vehicle history

**Required:**

- `vin`

**Optional:**

- None

**Example:**

```php
$history = $carsxe->history(['vin' => 'WBAFR7C57CC811956']);
```

---

### `images` – Fetch images by make, model, year, trim

**Required:**

- `make`
- `model`

**Optional:**

- `year`
- `trim`
- `color`
- `transparent`
- `angle`
- `photoType`
- `size`
- `license`

**Example:**

```php
$images = $carsxe->images(['make' => 'BMW', 'model' => 'X5', 'year' => '2019']);
```

---

### `recalls` – Get safety recall data for a VIN

**Required:**

- `vin`

**Optional:**

- None

**Example:**

```php
$recalls = $carsxe->recalls(['vin' => '1C4JJXR64PW696340']);
```

---

### `plateImageRecognition` – Read & decode plates from images

**Required:**

- `upload_url`

**Optional:**

- None

**Example:**

```php
$plateImage = $carsxe->plateImageRecognition(['upload_url' => 'https://api.carsxe.com/img/apis/plate_recognition.JPG']);
```

---

### `vinOcr` – Extract VINs from images using OCR

**Required:**

- `upload_url`

**Optional:**

- None

**Example:**

```php
$vinOcr = $carsxe->vinOcr(['upload_url' => 'https://api.carsxe.com/img/apis/plate_recognition.JPG']);
```

---

### `yearMakeModel` – Query vehicle by year, make, model and trim (optional)

**Required:**

- `year`
- `make`
- `model`

**Optional:**

- `trim`

**Example:**

```php
$ymm = $carsxe->yearMakeModel(['year' => '2023', 'make' => 'Toyota', 'model' => 'Camry']);
```

---

### `obdCodesDecoder` – Decode OBD error/diagnostic codes

**Required:**

- `code`

**Optional:**

- None

**Example:**

```php
$obdCode = $carsxe->obdCodesDecoder(['code' => 'P0115']);
```

### `lienAndTheft` – Check lien and theft status by VIN

**Required:**

- `vin`
  **Optional:**
- None
  **Example:**

```php
$lienTheft = $carsxe->lienAndTheft(['vin' => '2C3CDXFG1FH762860']);
```

---

### Notes

- **Parameter Names**: Use parameter names exactly as shown in this README to avoid errors.
- **Autoloader**: Add `require_once __DIR__ . '/vendor/autoload.php';` at the top of your script if not already included by your framework or tool.
- **Response Format**: All API responses are PHP arrays for easy access and manipulation.

---

## License

This library is licensed under the MIT License. See the LICENSE file for details.
