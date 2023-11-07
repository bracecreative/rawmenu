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

	// Get the initial selected value
	let myDog = document.querySelector(
		'input[name="foodCalc-select"]:checked'
	).value;

	// Add a click event listener to the elements with class "foodCalc-select"
	const selectInputs = document.querySelectorAll(".foodCalc-select");

	selectInputs.forEach((selectInput) => {
		selectInput.addEventListener("click", () => {
			document.getElementById("foodCalc-age").value = "";
			document.getElementById("foodCalc-weight").value = "";
			document.getElementById("foodCalc-result").textContent = "";

			myDog = document.querySelector(
				'input[name="foodCalc-select"]:checked'
			).value;

			if (myDog === "puppy") {
				document.getElementById("foodCalc-input--age").style.display = "flex";
			} else {
				document.getElementById("foodCalc-input--age").style.display = "none";
			}
		});
	});

	const calculateFood = (pet) => {
		let petFeed = 0;
		const age = document.getElementById("foodCalc-age").value;
		const weight = document.getElementById("foodCalc-weight").value;

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
			document.getElementById("foodCalc-result").textContent =
				petFeed + " grams";
			if (productPrice !== null && productWeight !== null) {
				const avgPrice = (
					Math.round((productPrice / productWeight) * petFeed * 100) / 100
				).toFixed(2);
				const message = `<p class>Based on the food selection of <b>${productTitle}</b> and the values entered in the calculator above, the average cost to feed your dog will be <b>£ ${avgPrice} per day.</b><sup>*</sup></p>`;
				document.getElementById("foodCalc-perDayPrice").innerHTML = message;
			}
		}
	};

	// Age & Weight Input Event Listeners
	const ageInput = document.getElementById("foodCalc-age");
	const weightInput = document.getElementById("foodCalc-weight");

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
