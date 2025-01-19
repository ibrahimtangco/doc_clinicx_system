	document.addEventListener('DOMContentLoaded', function() {
			const viewButtons = document.querySelectorAll('.modal-btn');
			const productDetailsContainer = document.querySelector('#modal-product-details');

			viewButtons.forEach(button => {
				button.addEventListener('click', () => {
					button.addEventListener('click', () => console.log('Button clicked'));
					const transaction = JSON.parse(button.getAttribute(
						'data-transaction')); // Parse the JSON string

					// Clear previous product details
					productDetailsContainer.innerHTML = '';
					document.querySelector('#transaction-code').innerHTML = transaction
						.transaction_code;
					// Display product details
					transaction.details.forEach(detail => {
						const productDetailRow = document.createElement('tr');
						productDetailRow.classList.add('bg-white', 'border-b',
							'hover:bg-gray-50');

						// Create Product Name Column
						const productNameColumn = document.createElement('td');
						productNameColumn.classList.add('bg-white', 'border-b',
							'hover:bg-gray-50');
						productNameColumn.textContent = detail.product.name;
						productDetailRow.appendChild(productNameColumn);

						// Create Price Column
						const priceColumn = document.createElement('td');
						priceColumn.classList.add('px-6', 'py-4', 'whitespace-nowrap');
						priceColumn.textContent = `Php ${detail.price_at_time_of_sale}`;
						productDetailRow.appendChild(priceColumn);

						// Create Quantity Column
						const quantityColumn = document.createElement('td');
						quantityColumn.classList.add('px-6', 'py-4', 'whitespace-nowrap');
						quantityColumn.textContent = detail.quantity; // Access the quantity
						productDetailRow.appendChild(quantityColumn);

						// Create Total Amount Column
						const totalAmountColumn = document.createElement('td');
						totalAmountColumn.classList.add('px-6', 'py-4', 'whitespace-nowrap');
						totalAmountColumn.textContent = `Php ${detail
							.total_amount}`; // Access the total amount
						productDetailRow.appendChild(totalAmountColumn);

						// Append the row to the product details table
						productDetailsContainer.appendChild(productDetailRow);
					});
				});
			});
		});
