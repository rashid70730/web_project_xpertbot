# 🎬 Zigzack API

Zigzack connects independent filmmakers with global film festivals.

## Authentication
All secured endpoints require Bearer Token (auth:sanctum).
Add in Postman under Authorization → Bearer Token.

---

## Endpoints

### User
	•	POST /api/register → Register a new user
	•	POST /api/login → Login and receive access token
	•	POST /api/logout → Logout (invalidate token)
	•	GET /api/user → Get logged-in user profile
	•	GET /api/list → List all users (admin use)

### Films
	•	POST /api/films → Upload a new film (auth required)
	•	GET /api/films → List all films
	•	GET /api/films/{id} → Show film details
	•	PUT /api/films/{id} → Update a film
	•	DELETE /api/films/{id} → Delete a film
	•	POST /api/films/{film}/accepte → Approve film (status → accepted, notify user)

### Festivals
	•	POST /api/festivals → Create a new festival
	•	GET /api/festivals → List all festivals
	•	GET /api/festivals/{id} → Show single festival
	•	PUT /api/festivals/{id} → Update festival
	•	DELETE /api/festivals/{id} → Delete festival

### Festival Users
	•	POST /api/festival-users → Link user to a festival (participation)
	•	GET /api/festival-users/{festivalId}/users → Get all users in a festival
	•	GET /api/festival-users/{userId}/festivals → Get all festivals a user joined

### Festival Films
	•	POST /api/festival-films → Submit film to a festival
	•	GET /api/festivals/{id}/films → List films in a festival
	•	GET /api/festival-films/{festivalId}/films → Films by festival ID
	•	GET /api/festival-films/{filmId}/festivals → Festivals by film ID
	•	GET /api/festivals/{id}/films/count → Count films in a festival

### Plans
	•	POST /api/plans → Create a subscription plan
	•	GET /api/plans → List all plans
	•	PUT /api/plans/{id} → Update a plan
	•	DELETE /api/plans/{id} → Delete a plan


### Subscriptions
	•	POST /api/subscriptions → Create a subscription
	•	GET /api/subscriptions → List subscriptions
	•	GET /api/subscriptions/{id} → Show subscription details
	•	PUT /api/subscriptions/{id} → Update subscription
	•	DELETE /api/subscriptions/{id} → Delete subscription
	•	GET /api/subscriptions/user/{userId} → Subscriptions of a user
	•	GET /api/subscriptions/plan/{planId} → Subscriptions under a plan
	•	GET /api/subscriptions/active → Active subscriptions


### Payments
	•	POST /api/payments → Record a new payment
	•	GET /api/payments → List all payments
	•	GET /api/payments/{id} → Show payment details
	•	PUT /api/payments/{id} → Update payment
	•	DELETE /api/payments/{id} → Delete payment
	•	GET /api/payments/user/{userId} → Get all payments of a user
	•	POST /api/pay → Trigger payment processing


### Views (Analytics)
	•	POST /api/views → Record a new view (film, festival, plan)
	•	GET /api/views/user/{userId} → Views by user
	•	GET /api/views/film/{filmId} → Views of a film
	•	GET /api/views/festival/{festivalId} → Views of a festival
	•	GET /api/views/plan/{planId} → Views of a plan

---



### Notes
	•	All CRUD endpoints follow REST conventions.
	•	Use Bearer Token for all write/update/delete requests.
	•	Responses are returned as JSON.