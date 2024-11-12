# Laravel Product Catalog Importer

This Laravel application allows you to manage products and categories with the following features:

1. **CSV Import**: Import products and categories from a CSV file. Each product can belong to multiple categories, and categories will be created if they don’t already exist.
2. **XML Feed Generation**: Generate an XML feed that includes all products and their categories in a structured XML format.

## Installation

1. **Clone the Repository**:
    ```bash
    git clone <repository_url>
    cd <repository_directory>
    ```

2. **Install Dependencies**:
    ```bash
    composer install
    ```

3. **Configure Environment**:
    - Copy the `.env.example` to `.env` and set up your database configuration.
    - Run database migrations:
        ```bash
        php artisan migrate
        ```

4. **Run the Application**:
    ```bash
    php artisan serve
    ```

## Usage

### Import Products from CSV

To import products, place a CSV file in the `storage/app` directory. The CSV should include columns for `name`, `price`, and up to three categories. Run the import command:

```bash
php artisan import:products storage/app/your_file.csv
```


### Generate XML Feed

To create an XML feed of all products and categories, use the following route in your browser or API client:
```bash
http://localhost/products/xml-feed
```
This will output the product feed in XML format.


### Testing

Run the test suite to confirm functionality:
```bash
php artisan test
```
This markdown file can now be saved as `README.md` and provides a clear installation and usage guide for the application.


