/* WOOCOMMERCE PRODUCTS */
/* Server API Fetch Woocommerce Product */
async function handler(req, res) {
	if (req.method === "GET") {
		const productID = 596;
		const apiConsumerKey = `${process.env.WOOCOMMERCE_API_CONSUMER_KEY}`;
		const apiConsumerSecret = `${process.env.WOOCOMMERCE_API_CONSUMER_SECRET}`;

		try {
			const response = await fetch(
				`https://mydummysite.co.uk/rawmenu/wp-json/wc/v3/products/${productID}?consumer_key=${apiConsumerKey}&consumer_secret=${apiConsumerSecret}`
			);

			if (!response?.ok) {
				throw new Error("Network response was not ok");
			}

			const data = await response.json();

			if (data) {
				res.status(200).json({data});
			} else {
				throw new Error("No Product found");
			}
		} catch (error) {
			console.error("Error fetching Woocommerce Product:", error);
			res.status(500).json({error: "Error fetching Woocommerce Product"});
		}
	} else {
		res.status(405).end();
	}
}
