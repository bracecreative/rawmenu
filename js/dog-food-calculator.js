export default function (productDetails) {
	const productName = $("h1.productView-title").text();
	let productWeight = null;

	if (productDetails.weight) {
		productWeight = productDetails.weight.value;
	}
	let productPrice = null;

	if ("with_tax" in productDetails.price) {
		productPrice = productDetails.price.with_tax.value;
	} else if ("without_tax" in productDetails.price) {
		productPrice = productDetails.price.without_tax.value;
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
