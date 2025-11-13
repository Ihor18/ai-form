# AI Actor Form

A small Laravel project using **Clean Architecture**.  
Users can submit actor information, which is processed with OpenAI, saved to the database, and displayed.

---

## Features

- Submit email and actor description
- Validate input (required & unique)
- Extract actor data (First Name, Last Name, Address, Height, Weight, Gender, Age) via OpenAI
- AJAX form submission with JSON responses
- View all submitted actors
- API endpoint to see the current OpenAI prompt

---

## Usage

- Start the application with Sail (`./vendor/bin/sail up -d`)
- To test the API, set `APP_ENV=production` and add your OpenAI API key
- Open `/docs/api` to explore the API with Laravel Scramble

---

## Notes

- `ActorService` handles domain logic
- `OpenAIClientInterface` can be mocked for testing
- Simple Blade templates with Tailwind
