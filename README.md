# Pixee Coding Test

## Project Setup

1. **Clone the Repository**  
   Clone the repository using the command:

    ```bash
    git clone https://github.com/vdvcoder/pixee-codingtest
    ```

2. **Navigate to the Project Directory**  
   Change into the project folder:

    ```bash
    cd pixee-codingtest
    ```

3. **Install Dependencies**  
   Install PHP and JavaScript dependencies:

    ```bash
    composer install
    npm install
    ```

4. **Build Assets**  
   Compile the project assets:

    ```bash
    npm run build
    ```

5. **Configure Environment**  
   Copy the example `.env` file:

    ```bash
    cp .env.example .env
    ```

6. **Generate Application Key**  
   Generate a unique application key:

    ```bash
    php artisan key:generate
    ```

7. **Create Databases**  
   Create the following MySQL databases:

    - `pixee_codingtest`
    - `pixee_codingtest_test`

8. **Run Migrations and Seed Data**  
   Execute database migrations and seed the data:

    ```bash
    php artisan migrate --seed
    ```

9. **Access the Application**  
   Open [http://pixee-coding.test](http://pixee-coding.test) in your browser.

    **Default Login Credentials:**

    - **Email:** pixee@laravel.com
    - **Password:** Password  
      Or register a new user.
