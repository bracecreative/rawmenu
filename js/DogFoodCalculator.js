// localize Script Values
const productTitle = DogFoodCalculatorObject.product_name;
const productPrice = DogFoodCalculatorObject.product_price;
const productWeight = DogFoodCalculatorObject.product_weight;

/* SINGLE PRODUCT CALCULATOR */
/* Woocommerce Product Calculator */
const dogCalculator = async (productTitle, productPrice, productWeight) => {
	productTitle;
	productPrice;
	productWeight;

	// Dog Type Options
	const puppy = document.getElementById("puppy");
	const adultDog = document.getElementById("adultDog");
	const workingDog = document.getElementById("workingDog");

	// Dog Age & Weight Input options Listeners
	const ageInput = document.getElementById("dogAgeInput");
	const weightInput = document.getElementById("dogWeightInput");

	/* Gets the initial selected value */
	let myDog = puppy.value;

	// Dog Input Age Option
	const dogInputAgeOption = document.getElementById("dogInputAgeOption");

	/* Final dog food result recommendation 
	This is in grams (Example: 910 grams) */
	let finalResultRecommendation = document.getElementById(
		"finalResultRecommendation"
	);

	/* Final dog price result recommendation 
	This is in pounds(£) (Example: £2.39) */
	let finalResultPricePerDay = document.getElementById(
		"finalResultPricePerDay"
	);

	// Puppy Dog Option Selected
	puppy.addEventListener("click", () => {
		// Set the Users dog to Puppy
		myDog = puppy.value;

		// Display Dog Input Age Option
		dogInputAgeOption.style.display = "flex";

		// Styling Change
		puppy.style.backgroundColor = "#e78f01";
		adultDog.style.backgroundColor = "#a70107";
		workingDog.style.backgroundColor = "#a70107";

		// Clear Age & Weight Input Fields
		ageInput.value = " ";
		weightInput.value = " ";

		// Clear final dog food result recommendation
		finalResultRecommendation.textContent = " ";

		// Clear final dog price result recommendation
		finalResultPricePerDay.innerHTML = " ";
	});

	// Adult Dog Option Selected
	adultDog.addEventListener("click", () => {
		// Set the Users dog to Puppy
		myDog = adultDog.value;

		// Hide Dog Input Age Option
		dogInputAgeOption.style.display = "none";

		// Adult Button Styling Change
		puppy.style.backgroundColor = "#a70107";
		adultDog.style.backgroundColor = "#e78f01";
		workingDog.style.backgroundColor = "#a70107";

		// Clear Age & Weight Input Fields
		weightInput.value = " ";

		// Clear final dog food result recommendation
		finalResultRecommendation.textContent = " ";

		// Clear final dog price result recommendation
		finalResultPricePerDay.innerHTML = " ";
	});

	// Working Dog Option Selected
	workingDog.addEventListener("click", () => {
		myDog = workingDog.value;

		// Hide Dog Input Age Option
		dogInputAgeOption.style.display = "none";

		// Styling Change
		puppy.style.backgroundColor = "#a70107";
		adultDog.style.backgroundColor = "#a70107";
		workingDog.style.backgroundColor = "#e78f01";

		// Clear Age & Weight Input Fields
		weightInput.value = " ";

		// Clear final dog food result recommendation
		finalResultRecommendation.textContent = " ";

		// Clear final dog price result recommendation
		finalResultPricePerDay.innerHTML = " ";
	});

	// Dog Food Calculations (Including weight values )
	const calculateFood = (pet) => {
		let petFeed = 0;
		const age = ageInput.value;
		const weight = weightInput.value;

		if (pet === "puppy") {
			if (age !== "") {
				if (age < 4) {
					petFeed = weight * 80; // 8% of body weight
				} else if (age >= 4 && age < 6) {
					petFeed = weight * 70; // 7% of body weight
				} else if (age >= 6 && age < 9) {
					petFeed = weight * 40; // 4% of body weight
				} else if (age >= 9 && age < 12) {
					petFeed = weight * 30; // 3% of body weight
				} else if (age >= 12) {
					petFeed = weight * 20; // 2% of body weight
				}
			}
		} else if (pet === "adultDog" || pet === "workingDog") {
			if (weight > 0 && weight < 4) {
				petFeed = weight * 100; // 10% of body weight
			} else if (weight >= 3 && weight < 5) {
				petFeed = weight * 70; // 7% of body weight
			} else if (weight >= 5 && weight < 9) {
				petFeed = weight * 50; // 5% of body weight
			} else if (weight >= 9 && weight < 11) {
				petFeed = weight * 30; // 3% of body weight
			} else if (weight >= 11) {
				petFeed = weight * 20; // 2% of body weight
			}
		}

		if (petFeed !== 0) {
			finalResultRecommendation.textContent = petFeed + " grams";
			if (productPrice !== null && productWeight !== null) {
				const avgPrice = (
					Math.round((productPrice / productWeight) * petFeed * 100) / 100
				).toFixed(2);
				const message = `<p class>Based on the food selection of <b>${productTitle}</b> and the values entered in the calculator above, the average cost to feed your dog will be <b>£ ${avgPrice} per day.</b><sup>*</sup></p>`;
				finalResultPricePerDay.innerHTML = message;
			}
		}
	};

	// Weight Input
	weightInput.addEventListener("keyup", () => {
		calculateFood(myDog);
	});

	weightInput.addEventListener("change", () => {
		calculateFood(myDog);
	});

	// Age Input
	ageInput.addEventListener("keyup", () => {
		calculateFood(myDog);
	});

	ageInput.addEventListener("change", () => {
		calculateFood(myDog);
	});
};

// Usage: Call the dogCalculator function
dogCalculator(productTitle, productPrice, productWeight);
