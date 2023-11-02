/* WOOCOMMERCE PRODUCTS */
/* Fetch single Woocommerce Product
 from the server api endpoint */
const getWoocommerceProduct = async () => {
	try {
		const response = await fetch("/js/api/woocommerceProducts.js");

		if (!response.ok) {
			throw new Error("Network response was not ok");
		}

		return await response.json();
	} catch (error) {
		console.error("Error fetching Woocommerce Product:", error);
	}
};

(async () => {
	try {
		const currentProduct = await getWoocommerceProduct();
		// You can use 'currentProduct' here or pass it to other functions as needed.
		dogCalculator(currentProduct);
	} catch (error) {
		console.error("Error in the main function:", error);
	}
})();

/* SINGLE PRODUCT CALCULATOR */
/* Woocommerce Product Calculator */
function dogCalculator(productDetails) {
	console.log(productDetails);

	const productName = $("h1.productView-title").text();
	let productWeight = null;

	if (productDetails?.weight) {
		productWeight = productDetails?.weight;
	}
	let productPrice = null;

	// With Tex
	if ("with_tax" in productDetails?.price) {
		productPrice = productDetails.price;
		// Without Tex
	} else if ("without_tax" in productDetails?.regular_price) {
		productPrice = productDetails?.regular_price;
	} else {
		productPrice = productDetails.price;
	}

	let myDog = $('input[name="foodCalc-select"]:checked').val();
	$(".foodCalc-select").on("click", () => {
		document.getElementById("foodCalc-age").value = "";
		document.getElementById("foodCalc-weight").value = "";
		$("#foodCalc-result").text("");

		myDog = $('input[name="foodCalc-select"]:checked').val();
		if (myDog === "puppy") {
			$("#foodCalc-input--age").show();
		} else {
			$("#foodCalc-input--age").hide();
		}
	});

	function calculateFood(pet) {
		let petFeed = 0;
		const age = $("#foodCalc-age").val();
		const weight = $("#foodCalc-weight").val();

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
			$("#foodCalc-result").text(`${petFeed} grams`);
			if (productPrice !== null && productWeight !== null) {
				const avgPrice = (
					Math.round((productPrice / productWeight) * petFeed * 100) / 100
				).toFixed(2);
				const message = `<p class>Based on the food selection of <b>${productName}</b> and the values entered in the calculator above, the average cost to feed your dog will be <b>£ ${avgPrice} per day.</b><sup>*</sup></p>`;
				$("#foodCalc-perDayPrice").html(message);
			}
		}
	}

	$("#foodCalc-weight").on("keyup change", () => {
		calculateFood(myDog);
	});
	$("#foodCalc-age").on("keyup change", () => {
		calculateFood(myDog);
	});
}
