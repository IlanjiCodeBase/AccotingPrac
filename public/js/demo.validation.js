/*
 * Dandelion Admin v1.0 - Form Validation JS
 *
 * This file is part of Dandelion Admin, an Admin template build for sale at ThemeForest.
 * For questions, suggestions or support request, please mail me at maimairel@yahoo.com
 *
 * Development Started:
 * March 25, 2012
 *
 */

(function($) {
	$(document).ready(function(e) {
		if($.fn.chosen) {
			$("#da-ex-val-chzn").chosen().bind("change", function(){
				$("#da-ex-validate3").validate().element($(this));
			});
		}
		
		if($.fn.spinner) {
			$("#da-ex-val-spin").spinner();
		}
		
		if($.fn.validate) {
			$("#add-company").validate({
				rules: {
					company: {
						required: true
					}, 
					username: {
						required: true, 
						email: true
					}, 
					cuen: {
						required: true, 
					}, 
					gst: {
						required: true, 
					},
					password: {
						required: true, 
						minlength: 8
					}, 
					cpassword: {
						required: true, 
						minlength: 8, 
						equalTo: '#password'
					},
					street_name: {
						required: true, 
					},
					country: {
						required: true, 
					},
					start_date: {
						required: true, 
					},
					end_date: {
						required: true, 
					},
					currency: {
						required: true, 
					},
				}, 
				messages : {
					username 	: "Enter a valid email id",
					company  	: "please specify a company name",
					cuen 		: "Enter unique entity number",
					gst 		: "Enter gst registration number",
					street_name : "Enter a street name",
					country 	: "Please select a country",
					start_date 	: "Please select financial year start date",
					end_date 	: "Please select financial year end date",
				},
				invalidHandler: function(form, validator) {
					var errors = validator.numberOfInvalids();
					if (errors) {
						var message = errors == 1
						? 'You missed 1 field. It has been highlighted'
						: 'You missed ' + errors + ' fields. They have been highlighted';
						$("#da-ex-val1-error").html(message).show();
					} else {
						$("#da-ex-val1-error").hide();
					}
				},
				submitHandler: function (form) {
					//$("#register").attr({ disabled:true, value:"Submitting..." });
					//form.submit();

			        var start   = $('#start_date').datepicker('getDate');
			        var end 	= $('#end_date').datepicker('getDate');
			        var days    = (end - start)/1000/60/60/24;
			        /*alert(start);
			        alert(end);
			        alert(days);
			        return false;*/
			        if(days==-1 || days==364) {
			           form.submit();
			           return true;
			        } else {
			        	alert('Financial start and end date should be exactly one year');
						return false;
					}
				}
			});

			$("#add-user").validate({
				rules: {
					company: {
						required: true
					}, 
					username: {
						required: true, 
						email: true
					}, 
					password: {
						required: true, 
						minlength: 8
					}, 
					cpassword: {
						required: true, 
						minlength: 8, 
						equalTo: '#password'
					},
					account_type: {
						required: true, 
					},
				}, 
				messages : {
					username 	  : "Enter a valid email id",
					company  	  : "please specify a company name",
					account_type  : "Please select an account type",
				},
				invalidHandler: function(form, validator) {
					var errors = validator.numberOfInvalids();
					if (errors) {
						var message = errors == 1
						? 'You missed 1 field. It has been highlighted'
						: 'You missed ' + errors + ' fields. They have been highlighted';
						$("#da-ex-val1-error").html(message).show();
					} else {
						$("#da-ex-val1-error").hide();
					}
				},
				submitHandler: function (form) {
					//$("#register").attr({ disabled:true, value:"Submitting..." });
					form.submit();
					//return false;
				}
			});

			
			$("#update-profile").validate({
				rules: {
					username: {
						required: true, 
						email: true
					}, 
					password: {
						required: true, 
						minlength: 8
					}, 
					cpassword: {
						required: true, 
						minlength: 8, 
						equalTo: '#password'
					},
				}, 
				messages : {
					username 	  : "Enter a valid email id",
				},
				invalidHandler: function(form, validator) {
					var errors = validator.numberOfInvalids();
					if (errors) {
						var message = errors == 1
						? 'You missed 1 field. It has been highlighted'
						: 'You missed ' + errors + ' fields. They have been highlighted';
						$("#da-ex-val1-error").html(message).show();
					} else {
						$("#da-ex-val1-error").hide();
					}
				},
				submitHandler: function (form) {
					//$("#register").attr({ disabled:true, value:"Submitting..." });
					form.submit();
					//return false;
				}
			});

			$("#add-opening-balance").validate({
				submitHandler: function (form) {
					var total_debit  = $("#total_debit").val();
					var total_credit = $("#total_credit").val();
					if(Number(numberWithOutCommasInput(total_debit))==Number(numberWithOutCommasInput(total_credit))) {
						form.submit();
						return true;
					} else {
						alert('Total debit and credit balance must be equal');
						return false;
					}
				}
			});

			$("#send-announcement").validate({
				rules: {
					company: {
						required: true,
					}, 
					'users[]': {
						required: true,
					}, 
					subject: {
						required: true, 
						minlength: 5
					}, 
					message: {
						required: true, 
						minlength: 10
					}, 
					
				}, 
				messages : {
					'company[]'	  : "Please select company",
				},
				invalidHandler: function(form, validator) {
					var errors = validator.numberOfInvalids();
					if (errors) {
						var message = errors == 1
						? 'You missed 1 field. It has been highlighted'
						: 'You missed ' + errors + ' fields. They have been highlighted';
						$("#da-ex-val1-error").html(message).show();
					} else {
						$("#da-ex-val1-error").hide();
					}
				},
				submitHandler: function (form) {
					//$("#register").attr({ disabled:true, value:"Submitting..." });
					form.submit();
					//return false;
				}
			});

			$("#add-accounts").validate({
				rules: {
					accountType: {
						required: true
					}, 
					name: {
						required: true
					}, 
				}, 
				invalidHandler: function(form, validator) {
					var errors = validator.numberOfInvalids();
					if (errors) {
						var message = errors == 1
						? 'You missed 1 field. It has been highlighted'
						: 'You missed ' + errors + ' fields. They have been highlighted';
						$("#da-ex-val1-error").html(message).show();
					} else {
						$("#da-ex-val1-error").hide();
					}
				}
			});

			$("#edit-accounts").validate({
				rules: {
					name: {
						required: true
					}, 
				}, 
				invalidHandler: function(form, validator) {
					var errors = validator.numberOfInvalids();
					if (errors) {
						var message = errors == 1
						? 'You missed 1 field. It has been highlighted'
						: 'You missed ' + errors + ' fields. They have been highlighted';
						$("#da-ex-val1-error").html(message).show();
					} else {
						$("#da-ex-val1-error").hide();
					}
				}
			});

		    $("#opening_balance_account").validate({
				rules: {
					balance_debit: {
						required: true,
						number: true
					}, 
					balance_credit: {
						required: true,
						number: true
					},
				}, 
				invalidHandler: function(form, validator) {
					var errors = validator.numberOfInvalids();
					if (errors) {
						var message = errors == 1
						? 'You missed 1 field. It has been highlighted'
						: 'You missed ' + errors + ' fields. They have been highlighted';
						$("#da-ex-val1-error").html(message).show();
					} else {
						$("#da-ex-val1-error").hide();
					}
				},
				submitHandler: function (form) {
					var debit  = $("#balance_debit").val();
					var credit = $("#balance_credit").val();
					if(Number(numberWithCommasInput(debit))!=Number(numberWithCommasInput(credit))) {
						alert("Debit and Credit Opening Balance Must Be Same");
						return false;
					} else {
						form.submit();
						return true;
					}
				}
			});

			$("#add-customer").validate({
				rules: {
					customer_name: {
						required: true
					}, 
					customer_id: {
						required: true
					},
					address1: {
						required: true,
						minlength: 10
					}, 
					customer_reg_no: {
						required: true
					},
					office_number: {
						required: true
					},
					city: {
						required: true
					},
					country: {
						required: true
					},					
					postcode: {
						required: true
					},
					website: {
						url: true
					},
					coa_link: {
						required: true
					}
				}, 
				messages : {
					customer_name 	: "Enter a Customer Name",
					customer_id 	: "Enter a Customer ID",
					customer_reg_no : "Enter a Customer Unique Registration Number",
					city 			: "Enter a City",
					country 		: "Select a Country",
					company_gst_no 	: "Enter a company GST registration number",
					postcode 		: "Enter a Postal Code",
					gst_status 	    : "Enter a GST status verified date",
					coa_link 	    : "Select any COA",
				},
				invalidHandler: function(form, validator) {
					var errors = validator.numberOfInvalids();
					if (errors) {
						var message = errors == 1
						? 'You missed 1 field. It has been highlighted'
						: 'You missed ' + errors + ' fields. They have been highlighted';
						$("#da-ex-val1-error").html(message).show();
					} else {
						$("#da-ex-val1-error").hide();
					}
				},
				submitHandler: function (form) {
					form.submit();
					/*var ship_count = $("#shipping_counter").val();
					var key_count  = $("#contact_counter").val();
					if(ship_count==0 || ship_count=='') {
						alert("Add atleast one shipping address");
						return false;
					} else if(key_count==0 || key_count=='') {
						alert("Add atleast one contact person");
						return false;
					} else {
						form.submit();
					}*/
				}
			});

			$("#add-vendor").validate({
				rules: {
					vendor_name: {
						required: true
					}, 
					vendor_id: {
						required: true
					},
					address1: {
						required: true,
						minlength: 10
					}, 
					vendor_reg_no: {
						required: true
					},
					office_number: {
						required: true
					},
					city: {
						required: true
					},
					country: {
						required: true
					},
					postcode: {
						required: true
					},
					website: {
						url: true
					}
				}, 
				messages : {
					vendor_name 	: "Enter a Vendor Name",
					vendor_id 		: "Enter a Vendor ID",
					vendor_reg_no   : "Enter a Vendor Unique Registration Number",
					city 			: "Enter a City",
					country 		: "Select a Country",
					company_gst_no 	: "Enter a company GST registration number",
					postcode 		: "Enter a Postal Code",
					gst_status 	    : "Enter a GST status verified date",
				},
				invalidHandler: function(form, validator) {
					var errors = validator.numberOfInvalids();
					if (errors) {
						var message = errors == 1
						? 'You missed 1 field. It has been highlighted'
						: 'You missed ' + errors + ' fields. They have been highlighted';
						$("#da-ex-val1-error").html(message).show();
					} else {
						$("#da-ex-val1-error").hide();
					}
				},
				submitHandler: function (form) {
					form.submit();
					/*
					var key_count  = $("#contact_counter").val();
					if(key_count==0 || key_count=='') {
						alert("Add atleast one contact person");
						return false;
					} else {
						form.submit();
					}
					*/
				}
			});

			
			$("#add-receipt").validate({
				rules: {
					receipt_name: {
						required: true
					}, 
					file: {
						required: true,
						accept: "image/jpg,image/jpeg,image/png,image/gif,application/pdf"
					},
				}, 
				messages : {
					receipt_name 	: "Enter receipt Name",
				},
				invalidHandler: function(form, validator) {
					var errors = validator.numberOfInvalids();
					if (errors) {
						var message = errors == 1
						? 'You missed 1 field. It has been highlighted'
						: 'You missed ' + errors + ' fields. They have been highlighted';
						$("#da-ex-val1-error").html(message).show();
					} else {
						$("#da-ex-val1-error").hide();
					}
				},
				submitHandler: function (form) {
					//$("#register").attr({ disabled:true, value:"Submitting..." });
					form.submit();
					//return false;
				}
			});


			$("#add-product").validate({
				rules: {
					product_name: {
						required: true, 
						minlength: 5
					}, 
					product_id: {
						required: true, 
					}, 
					income_account: {
						required: true, 
					}, 
					price: {
						required: true, 
						number: true,
					}, 
					currency: {
						required: true, 
					}, 
					description: {
						minlength:10,
					}, 
					
				}, 
				messages : {
					product_id 	    : "Enter Product ID",
					income_account 	: "Select income account type",
					currency 	    : "Select Currency",
				},
				invalidHandler: function(form, validator) {
					var errors = validator.numberOfInvalids();
					if (errors) {
						var message = errors == 1
						? 'You missed 1 field. It has been highlighted'
						: 'You missed ' + errors + ' fields. They have been highlighted';
						$("#da-ex-val1-error").html(message).show();
					} else {
						$("#da-ex-val1-error").hide();
					}
				},
				submitHandler: function (form) {
					//$("#register").attr({ disabled:true, value:"Submitting..." });
					form.submit();
					//return false;
				}
			});

			$("#add-tax").validate({
				rules: {
					category_code: {
						required: true, 
					}, 
					percentage: {
						required: true, 
						number: true
					}, 
					tax_type: {
						required: true, 
					},
					description: {
						required: true, 
						minlength:10
					}, 
					
				}, 
				messages : {
					category_code 	: "Enter Tax Code",
					tax_type 	    : "Select Tax Type",
				},
				invalidHandler: function(form, validator) {
					var errors = validator.numberOfInvalids();
					if (errors) {
						var message = errors == 1
						? 'You missed 1 field. It has been highlighted'
						: 'You missed ' + errors + ' fields. They have been highlighted';
						$("#da-ex-val1-error").html(message).show();
					} else {
						$("#da-ex-val1-error").hide();
					}
				},
				submitHandler: function (form) {
					//$("#register").attr({ disabled:true, value:"Submitting..." });
					form.submit();
					//return false;
				}
			});


			$("#reset-password").validate({
				rules: {
					password: {
						required: true, 
						minlength: 8
					}, 
					cpassword: {
						required: true, 
						minlength: 8, 
						equalTo: '#password'
					},
				}, 
				messages : {
				},
				invalidHandler: function(form, validator) {
					var errors = validator.numberOfInvalids();
					if (errors) {
						var message = errors == 1
						? 'You missed 1 field. It has been highlighted'
						: 'You missed ' + errors + ' fields. They have been highlighted';
						$("#da-ex-val1-error").html(message).show();
					} else {
						$("#da-ex-val1-error").hide();
					}
				},
				submitHandler: function (form) {
					//$("#register").attr({ disabled:true, value:"Submitting..." });
					form.submit();
					//return false;
				}
			});


			$("#invoice-customization").validate({
				rules: {
					invoice_prefix: {
						required: true, 
						minlength: 2, 
						maxlength: 10
					}, 
				}, 
				messages : {
				},
				invalidHandler: function(form, validator) {
					var errors = validator.numberOfInvalids();
					if (errors) {
						var message = errors == 1
						? 'You missed 1 field. It has been highlighted'
						: 'You missed ' + errors + ' fields. They have been highlighted';
						$("#da-ex-val1-error").html(message).show();
					} else {
						$("#da-ex-val1-error").hide();
					}
				},
				submitHandler: function (form) {
					//$("#register").attr({ disabled:true, value:"Submitting..." });
					form.submit();
					//return false;
				}
			});



		$(document).on('click', '.add_income_transaction', function(e) {
			$("#add-income").validate({
				debug: false,
				rules: {
					date: {
						required: true
					}, 
					receipt: {
						required: true
					}, 
					customer: {
						required: true
					}, 
					payment_account: {
						required: true
					}, 
					credit_term: {
						required: true
					},  
					currency: {
						required: true
					}, 
					income_type: {
						required: true
					}, 
					amount: {
						required: true,
						number: true
					},
					description: {
						required: true,
						minlength: 10
					},
				},
				messages : {
					date 		: "Select the date",
					receipt 	: "Enter Receipt Number",
					customer 	: "Select Customer",
					payment_account : "Select Payment Account",
					credit_term : "Select Credit Term",
					currency 	: "Select Currency",
					income_type : "Select Income Type",
				},
				submitHandler: function (form) {
					/*var pay_account      = $("#payment_account").val();*/
					var credits   		 = $("#credit_term").val();
					var currency   		 = $("#currency").val();
					//var payment_account  = pay_account.split('_');
					/*if((Number(payment_account[1])==1 && Number(payment_account[2]==1)) && credits!=1) {
						alert("Credit term must be upon receipt if the payment account is bank or cash account");
						return false;
					} else if((Number(payment_account[1])!=6 && Number(payment_account[2]!=1)) && credits==1) {
						alert("Credit term must not be upon receipt if the payment account is not a bank or cash account");
						return false;
					} else {*/
						var tax_amount     = 0;
						var trigger        = $("#payment_trigger").val();
						var income_amount  = $("#amount").val();
						var tax_code       = $("#tax_code").val();
						var tax 		   = tax_code.split('_');
						if(tax[0]!=0) {
							tax_amount = (Number(numberWithOutCommasInput(income_amount)) * Number(tax[1]) / 100);
						} 
						
						var overall_amount = Number(numberWithOutCommasInput(income_amount))+tax_amount;
						var pay_amount       = $("#addpay_pay_amount").val();
						var discount_amount  = $("#addpay_discount_payment_amount").val();
						var paying_amount    = Number(numberWithOutCommasInput(pay_amount)) + Number(numberWithOutCommasInput(discount_amount));
						/*alert(overall_amount);
						return false;*/
						if(trigger==1) {
							if(Number(paying_amount) > Number(overall_amount) && currency=='SGD' && $("#add_payment_status").not(":checked")) {
							    alert("You have entered more than original amount. Amount is "+overall_amount);
								return false;
							} else if(Number(paying_amount) != Number(overall_amount) && currency=='SGD' && $("#add_payment_status").is(":checked")) {
							    alert("Payment amount and Original amount must be equal if the payment is final. Amount is "+overall_amount);
								return false;
							} else {
								form.submit();
								//return false;
							}
						} else {
							form.submit();
							//return false;
						}
					//}
				}
				
			});
		});

		$(document).on('click', '.add_approve_income_transaction', function(e) {
			$("#add-income").validate({
				debug: false,
				rules: {
					date: {
						required: true
					}, 
					receipt: {
						required: true
					}, 
					customer: {
						required: true
					}, 
					payment_account: {
						required: true
					}, 
					credit_term: {
						required: true
					},  
					currency: {
						required: true
					}, 
					income_type: {
						required: true
					}, 
					amount: {
						required: true,
						number: true
					},
					approval_for: {
						required: true,
					},
					description: {
						required: true,
						minlength: 10
					},
				},
				messages : {
					date 		: "Select the date",
					receipt 	: "Enter Receipt Number",
					customer 	: "Select Customer",
					payment_account : "Select Payment Account",
					credit_term : "Select Credit Term",
					currency 	: "Select Currency",
					income_type : "Select Income Type",
					approval_for : "Select Super user (or) manager for approval",
				},
				submitHandler: function (form) {
					//alert("1");
					/*var pay_account      = $("#payment_account").val();*/
					var credits   		 = $("#credit_term").val();
					var currency   		 = $("#currency").val();
					/*var payment_account  = pay_account.split('_');*/
					//alert("1");
					//console.log(payment_account);
					//return false;
					/*if((Number(payment_account[1])==1 && Number(payment_account[2]==1)) && credits!=1) {
						alert("Credit term must be upon receipt if the payment account is bank or cash account");
						return false;
					} else if((Number(payment_account[1])!=6 && Number(payment_account[2]!=1)) && credits==1) {
						alert("Credit term must not be upon receipt if the payment account is not a bank or cash account");
						return false;
					} else {*/
						//alert("2");
						var tax_amount	   = 0;
						var trigger        = $("#payment_trigger").val();
						var income_amount  = $("#amount").val();
						var tax_code       = $("#tax_code").val();
						var tax 		   = tax_code.split('_');
						if(tax[0]!=0) {
							tax_amount = (Number(numberWithOutCommasInput(income_amount)) * Number(tax[1]) / 100);
						}
						var overall_amount = Number(numberWithOutCommasInput(income_amount))+tax_amount;
						var pay_amount       = $("#addpay_pay_amount").val();
						var discount_amount  = $("#addpay_discount_payment_amount").val();
						var paying_amount    = Number(numberWithOutCommasInput(pay_amount)) + Number(numberWithOutCommasInput(discount_amount));
						/*alert(overall_amount);
						return false;*/
						//alert(trigger);
						//alert(overall_amount);
						//alert(paying_amount);
						if(trigger==1) {
							//alert(Number(numberWithOutCommasInput(paying_amount)));
							//alert(Number(numberWithOutCommasInput(overall_amount)));
							if(Number(paying_amount) > Number(overall_amount) && currency=='SGD' && $("#add_payment_status").not(":checked")) {
							    alert("You have entered more than original amount. Amount is "+overall_amount);
								return false;
							} else if(Number(paying_amount) != Number(overall_amount) && currency=='SGD' && $("#add_payment_status").is(":checked")) {
							    alert("Payment amount and Original amount must be equal if the payment is final. Amount is "+overall_amount);
								return false;
							} else {
								form.submit();
								//return false;
							}
						} else {
							form.submit();
						   //return false;
						}
					//}
					//alert("3");
				}
				
			});
		});


		$(document).on('click', '.copy_income_transaction', function(e) {
			$("#copy-income").validate({
				debug: false,
				rules: {
					date: {
						required: true
					}, 
					receipt: {
						required: true
					}, 
					customer: {
						required: true
					}, 
					pay_account: {
						required: true
					}, 
					credit_term: { 
						required: true
					},  
					currency: {
						required: true
					}, 
					income_type: {
						required: true
					}, 
					amount: {
						required: true,
						number: true
					},
					description: {
						required: true,
						minlength: 10
					},
				},
				messages : {
					date 		: "Select the date",
					receipt 	: "Enter Receipt Number",
					customer 	: "Select Customer",
					pay_account : "Select Payment Account",
					credit_term : "Select Credit Term",
					currency 	: "Select Currency",
					income_type : "Select Income Type",
				},
				
			});
		});

	$(document).on('click', '.add_expense_transaction', function(e) {
		$("#add-expense").validate({
				debug: false,
				rules: {
					date: {
						required: true
					}, 
					receipt: {
						required: true
					}, 
					vendor: {
						required: true
					}, 
					pay_account: {
						required: true
					}, 
					credit_term: {
						required: true
					},  
					currency: {
						required: true
					}, 
					permit_no: {
						required: true
					}, 
					discount_amount: {
						required: true,
						number:true
					}, 
				},
				messages : {
					date 		: "Select the date",
					receipt 	: "Enter Receipt Number",
					vendor   	: "Select Vendor",
					pay_account : "Select Payment Account",
					credit_term : "Select Credit Term",
					currency 	: "Select Currency",
					permit_no 	: "Enter Permit Number",
				},
				submitHandler: function (form) {
					//alert("1");
					/*var pay_account      = $("#payment_account").val();*/
					var credits   		 = $("#credit_term").val();
					/*var payment_account  = pay_account.split('_');*/
					//alert("1");
					//console.log(payment_account);
					//return false;
					/*if((Number(payment_account[1])<=6 && Number(payment_account[2]==1)) && credits!=1) {
						alert("Credit term must be upon receipt if the payment account is bank or cash account");
						return false;
					} else if(((Number(payment_account[1])>6) || (Number(payment_account[1])<=6 && Number(payment_account[2]!=1))) && credits==1) {
						alert("Credit term must not be upon receipt if the payment account is not a bank or cash account");
						return false;
					} else {*/
						//alert("2");
						var trigger        = $("#payment_trigger").val();
						var overall_amount = payTotal();
						var pay_amount       = $("#addpay_pay_amount").val();
						var discount_amount  = $("#addpay_discount_payment_amount").val();
						var paying_amount    = Number(numberWithOutCommasInput(pay_amount)) + Number(numberWithOutCommasInput(discount_amount));
						var currency 	   = $("#currency").val();
						if(currency!='SGD') {
							var convert_amount = $("#foreign_currency").val();
						} else {
							var convert_amount = overall_amount;
						}
						/*alert(overall_amount);
						alert(convert_amount);
						alert(paying_amount);
						return false;*/
						if(trigger==1) {
							if(Number(paying_amount) > Number(numberWithCommas(convert_amount,'format')) && currency=='SGD' && $("#add_payment_status").not(":checked")) {
							    alert("You have entered more than original amount. Amount is "+convert_amount);
								return false;
							} else if(Number(paying_amount) != Number(numberWithCommas(convert_amount,'format')) && currency=='SGD' && $("#add_payment_status").is(":checked")) {
							    alert("Payment amount and Original amount must be equal if the payment is final. Amount is "+convert_amount);
								return false;
							} else {
								form.submit();
								//return false;
							}
						} else {
							form.submit();
						   //return false;
						}
					//}
					//alert("3");
				}
				
			});
	});


	$(document).on('click', '.add_approve_expense_transaction', function(e) {
		$("#add-expense").validate({
				debug: false,
				rules: {
					date: {
						required: true
					}, 
					receipt: {
						required: true
					}, 
					vendor: {
						required: true
					}, 
					pay_account: {
						required: true
					}, 
					credit_term: {
						required: true
					},  
					currency: {
						required: true
					}, 
					permit_no: {
						required: true
					}, 
					approval_for: {
						required: true,
					},
					discount_amount: {
						required: true,
						number:true
					}, 
				},
				messages : {
					date 		: "Select the date",
					receipt 	: "Enter Receipt Number",
					vendor   	: "Select Vendor",
					pay_account : "Select Payment Account",
					credit_term : "Select Credit Term",
					currency 	: "Select Currency",
					permit_no 	: "Enter Permit Number",
					approval_for : "Select Super user (or) manager for approval",
				},
				submitHandler: function (form) {
					/*//alert("1");
					var pay_account      = $("#payment_account").val();*/
					var credits   		 = $("#credit_term").val();
					/*var payment_account  = pay_account.split('_');*/
					//alert("1");
					//console.log(payment_account);
					//return false;
					/*if((Number(payment_account[1])<=6 && Number(payment_account[2]==1)) && credits!=1) {
						alert("Credit term must be upon receipt if the payment account is bank or cash account");
						return false;
					} else if(((Number(payment_account[1])>6) || (Number(payment_account[1])<=6 && Number(payment_account[2]!=1))) && credits==1) {
						alert("Credit term must not be upon receipt if the payment account is not a bank or cash account");
						return false;
					} else {*/
						//alert("2");
						var trigger        = $("#payment_trigger").val();
						var overall_amount = payTotal();
						var pay_amount       = $("#addpay_pay_amount").val();
						var discount_amount  = $("#addpay_discount_payment_amount").val();
						var paying_amount    = Number(numberWithOutCommasInput(pay_amount)) + Number(numberWithOutCommasInput(discount_amount));
						var currency 	   = $("#currency").val();
						if(currency!='SGD') {
							var convert_amount = $("#foreign_currency").val();
						} else {
							var convert_amount = overall_amount;
						}
						/*alert(overall_amount);
						alert(convert_amount);
						alert(paying_amount);
						return false;*/
						if(trigger==1) {
							if(Number(paying_amount) > Number(numberWithCommas(convert_amount,'format')) && currency=='SGD' && $("#add_payment_status").not(":checked")) {
							    alert("You have entered more than original amount. Amount is "+convert_amount);
								return false;
							} else if(Number(paying_amount) != Number(numberWithCommas(convert_amount,'format')) && currency=='SGD' && $("#add_payment_status").is(":checked")) {
							    alert("Payment amount and Original amount must be equal if the payment is final. Amount is "+convert_amount);
								return false;
							} else {
								form.submit();
								//return false;
							}
						} else {
							form.submit();
						   //return false;
						}
					//}
					//alert("3");
				}
				
			});
	});


	$(document).on('click', '.add_invoice_transaction', function(e) {
		$("#add-invoice").validate({
				debug: false,
				rules: {
					date: {
						required: true
					},
					customer: {
						required: true
					}, 
					credit_term: {
						required: true
					},  
					currency: {
						required: true
					}, 
					payment_discount: {
						required: true
					}, 
					non_revenue_tax: {
						required: true
					}, 
				},
				messages : {
					date 				: "Select the date",
					customer   			: "Select Customer",
					payment_discount 	: "Select Payment Discount",
					credit_term 		: "Select Credit Term",
					currency 			: "Select Currency",
					non_revenue_tax 	: "Choose non revenue tax",
				},
				submitHandler: function (form) {
					var credits   		 = $("#credit_term").val();

						var trigger        = $("#payment_trigger").val();
						var overall_amount = payTotal();
						var pay_amount       = $("#addpay_pay_amount").val();
						var discount_amount  = $("#addpay_discount_payment_amount").val();
						var paying_amount    = Number(numberWithOutCommasInput(pay_amount)) + Number(numberWithOutCommasInput(discount_amount));
						var currency 	   = $("#currency").val();
						if(currency!='SGD') {
							var convert_amount = $("#foreign_currency").val();
						} else {
							var convert_amount = overall_amount;
						}
						if(trigger==1) {
							if(Number(paying_amount) > Number(numberWithCommas(convert_amount,'format')) && currency=='SGD' && $("#add_payment_status").not(":checked")) {
							    alert("You have entered more than original amount. Amount is "+convert_amount);
								return false;
							} else if(Number(paying_amount) != Number(numberWithCommas(convert_amount,'format')) && currency=='SGD' && $("#add_payment_status").is(":checked")) {
							    alert("Payment amount and Original amount must be equal if the payment is final. Amount is "+convert_amount);
								return false;
							} else {
								form.submit();
							}
						} else {
							form.submit();
						}
				}
				
			});
		});

	$(document).on('click', '.add_approve_invoice_transaction', function(e) {
		$("#add-invoice").validate({
				debug: false,
				rules: {
					date: {
						required: true
					},
					customer: {
						required: true
					}, 
					credit_term: {
						required: true
					},  
					currency: {
						required: true
					}, 
					payment_discount: {
						required: true
					},  
					approval_for: {
						required: true,
					},
					non_revenue_tax: {
						required: true
					}, 
				},
				messages : {
					date 				: "Select the date",
					customer   			: "Select Customer",
					payment_discount 	: "Select Payment Discount",
					credit_term 		: "Select Credit Term",
					currency 			: "Select Currency",
					non_revenue_tax 	: "Choose non revenue tax",
					approval_for : "Select Super user (or) manager for approval",
				},
				submitHandler: function (form) {
					var credits   		 = $("#credit_term").val();

						var trigger        = $("#payment_trigger").val();
						var overall_amount = payTotal();
						var pay_amount       = $("#addpay_pay_amount").val();
						var discount_amount  = $("#addpay_discount_payment_amount").val();
						var paying_amount    = Number(numberWithOutCommasInput(pay_amount)) + Number(numberWithOutCommasInput(discount_amount));
						var currency 	   = $("#currency").val();
						if(currency!='SGD') {
							var convert_amount = $("#foreign_currency").val();
						} else {
							var convert_amount = overall_amount;
						}
						/*alert(overall_amount);
						alert(convert_amount);
						alert(paying_amount);
						return false;
*/						if(trigger==1) {
							if(Number(paying_amount) > Number(numberWithCommas(convert_amount,'format')) && currency=='SGD' && $("#add_payment_status").not(":checked")) {
							    alert("You have entered more than original amount. Amount is "+convert_amount);
								return false;
							} else if(Number(paying_amount) != Number(numberWithCommas(convert_amount,'format')) && currency=='SGD' && $("#add_payment_status").is(":checked")) {
							    alert("Payment amount and Original amount must be equal if the payment is final. Amount is "+convert_amount);
								return false;
							} else {
								form.submit();
							}
						} else {
							form.submit();
						}
				}
				
			});
		});

			$("#add-payment").validate({
				debug: false,
				rules: {
					date: {
						required: true
					},
					pay_account: {
						required: true
					}, 
					pay_amount: {
						required: true
					},  
					pay_method: {
						required: true
					}, 
					payment_discount: {
						required: true
					},  
				},
				messages : {
					date 				: "Select the date",
					pay_account   		: "Select Payment Account",
					pay_amount   		: "Enter Amount",
					payment_discount 	: "Select Payment Discount",
					pay_method 			: "Select Payment Method",
				},
				submitHandler: function (form) {
					var currencyStatus  = $("#currency_status").val();
					var pendingAmount   = $("#pending_amount").val();
					var payingAmount    = $("#pay_amount").val();
					var discountAmount  = $("#discount_payment_amount").val();
					var paymentStatus   = $("#payment_status").val();
					var totalSum		= Number(numberWithOutCommasInput(payingAmount)) + Number(numberWithOutCommasInput(discountAmount)); 
					/*alert(currencyStatus);
					alert(pendingAmount);
					alert(payingAmount);
					alert(discountAmount);
					alert(totalSum);
					return false;*/
					if ($("#payment_status").is(":checked") && (Number(totalSum) != Number(pendingAmount)) && (currencyStatus==1)) {
					    alert("Amount due and payment amount with discount must be equal if the payment is final. Amount Due is "+pendingAmount);
						return false;
					} else if ($("#payment_status").not(":checked") && (Number(totalSum) > Number(pendingAmount)) && (currencyStatus==1)) {
					    alert("Payment amount is greater than amount due. Amount Due is "+pendingAmount);
						return false;
					} else {
						form.submit();
						return true;
					}
					
				}
				
			});


			$(document).on('click', '.add_credit_transaction', function(e) {
				$("#add-credit").validate({
					debug: false,
					rules: {
						date: {
							required: true
						},
						customer: {
							required: true
						}, 
						invoice: {
							required: true
						}, 
						currency: {
							required: true
						}, 
						memo: {
							required: true,
							minlength: 10
						},
					},
					messages : {
						date 		: "Select the date",
						customer 	: "Select Customer",
						currency 	: "Select Currency",
						invoice     : "Select Invoice No",
					},
					submitHandler: function (form) {
						var date = $("#date").datepicker('getDate');
						var idate = $("#inv_date").datepicker('getDate');
						var invdate = $("#inv_date").val();
						var days    = (date - idate)/1000/60/60/24;
						if(days<0) {
							alert("Credit note date should be greater than or equal to invoice date "+invdate);
							return false;
						} else {
							form.submit();
							return true;
						}

					}
					
				});
		    });

		    $(document).on('click', '.add_approve_credit_transaction', function(e) {
				$("#add-credit").validate({
					debug: false,
					rules: {
						date: {
							required: true
						},
						customer: {
							required: true
						}, 
						invoice: {
							required: true
						}, 
						currency: {
							required: true
						}, 
						memo: {
							required: true,
							minlength: 10
						},  
						approval_for: {
							required: true,
						},
					},
					messages : {
						date 		: "Select the date",
						customer 	: "Select Customer",
						currency 	: "Select Currency",
						invoice     : "Select Invoice No",
						approval_for : "Select Super user (or) manager for approval",
					},
					submitHandler: function (form) {
						var date = $("#date").datepicker('getDate');
						var idate = $("#inv_date").datepicker('getDate');
						var invdate = $("#inv_date").val();
						var days    = (date - idate)/1000/60/60/24;
						if(days<0) {
							alert("Credit note date should be greater than or equal to invoice date "+invdate);
							return false;
						} else {
							form.submit();
							return true;
						}

					}
					
				});
		    });

		    $(document).on('click', '.add_journal_transaction', function(e) {
				$("#add-journal").validate({
					debug: false,
					rules: {
						date: {
							required: true
						},
						description: {
							required: true,
							minlength: 10
						},
					},
					messages : {
						date 		: "Select the date",
					},
					submitHandler: function (form) {
						var hiddenDebit   = $("#hidden_debit").val();
						var hiddenCredit  = $("#hidden_credit").val();
						if(Number(hiddenDebit) != Number(hiddenCredit)) {
							alert("Debit and Credit Amount must be equal");
							return false;
						} else {
							form.submit();
							return true;
						}
				  }
					
				});
		    });

		    $(document).on('click', '.add_approve_journal_transaction', function(e) {
				$("#add-journal").validate({
					debug: false,
					rules: {
						date: {
							required: true
						},
						description: {
							required: true,
							minlength: 10
						},  
						approval_for: {
							required: true,
						},
					},
					messages : {
						date 		: "Select the date",
						approval_for : "Select Super user (or) manager for approval",
					},
					submitHandler: function (form) {
						var hiddenDebit   = $("#hidden_debit").val();
						var hiddenCredit  = $("#hidden_credit").val();
						if(Number(hiddenDebit) != Number(hiddenCredit)) {
							alert("Debit and Credit Amount must be equal");
							return false;
						} else {
							form.submit();
							return true;
						}
				  }
					
				});
		    });

		   $("#report-period").validate({
				debug: false,
				rules: {
					from_date: {
						required: true
					},
					to_date: {
						required: true
					}, 
				},
				messages : {
					from_date 				: "Select from date",
					to_date 				: "Select to date",
				},
			});

		

			$("#add-expenses").validate({
				debug: false,
				rules: {
					date: {
						required: true
					}, 
					description: {
						required: true
					}, 
					amount: {
						required: true,
						number: true
					},
					category: {
						required: true
					},
					account: {
						required: true
					},
				},
				submitHandler: function (form) {
					var flag = 0;
					var split = $("#splits").val();
					var count = $("#split_counts").val();
					if(split!='') {
						var amount = $("#amounts").val();
						var splitAmount = $("#split_amounts").val();
						var total = amount-splitAmount;
						if(total==0) { 
							flag = 0; 
						} else {
							flag++;
						}
						if(flag!=0) {
							alert("Check the splited amount and the total amount");
							return false;
						} 
					  } 
			           $.ajax({
			                type: "POST",
			                url: "default/transactions/ajax-call",
			                data: $('#add-expense').serialize(),
			                success: function (html) {
			                    if (html == 'success') {
			                    	$('#add-expense').each(function(){
									   this.reset();
									});
			                        $('#add_expense').slideToggle(1000);
			                        $('#success').text('Expense successfully added');
			                        $('#viewVendor').hide();
			                        $('#success').fadeIn(1000);
			                        $('#success').fadeOut(3000);
			                        setTimeout("location.reload()", 5000);
			                    } else { alert(html); }
			                }
			            });  //end of $.ajax
		            return false;
		        }
			});

		$(document).on('click', '#edit_transaction', function(e) {
			$("#edit-income").validate({
				debug: false,
				rules: {
					date: {
						required: true
					}, 
					description: {
						required: true
					}, 
					amount: {
						required: true,
						number: true
					},
					category: {
						required: true
					},
					account: {
						required: true
					},
				},
				submitHandler: function (form) {

					var flag = 0;
					var splitAmount = 0;
					var split = $("#esplit").val();
					var count = $("#esplit_count").val();
					if(split!='' & count!=0) {
						var amount = $(".eamount").val();
						for(i=1;i<=count;i++) {
							var sub = $("#amount"+i).val();
							var splitAmount = Number(splitAmount)+Number(sub);
						}
						var total = amount-splitAmount;
						if(total==0) {
							flag = 0;
						} else {
							flag++;
						}
						if(flag!=0) {
							//alert(typeof(splitAmount));
							alert("Check the splitted amount and the total amount");
							return false;
						} 
					  } 
			           $.ajax({
			                type: "POST",
			                url: "default/transactions/ajax-call",
			                data: $('#edit-income').serialize(),
			                success: function (html) {
			                    if (html == 'success') {
			                    	$("#popup").bPopup().close();
			                    	$('#success').text('Transaction successfully updated');
			                        $('#success').fadeIn(1000);
			                        $('#success').fadeOut(3000);
			                        setTimeout("location.reload()", 5000);
								 }
			                }
			            });  //end of $.ajax
		            return false;
		        }
			});
		});

		$("#approve_pending_transaction").validate({
				rules: {				
				}, 
				messages : {
				},
				invalidHandler: function(form, validator) {
					var errors = validator.numberOfInvalids();
					if (errors) {
						var message = errors == 1
						? 'You missed 1 field. It has been highlighted'
						: 'You missed ' + errors + ' fields. They have been highlighted';
						$("#da-ex-val1-error").html(message).show();
					} else {
						$("#da-ex-val1-error").hide();
					}
				},
				submitHandler: function (form) {
					var total_count = $("#total_count").val();
					if(total_count==0 || total_count=='') {
						alert('Select atleast one transaction to approve');
						return false;
					} else {
						var confirmMsg = confirm('Are you sure want to approve the selected transactions?');
						if(confirmMsg) {
							form.submit();
							return true;
						} else {
							return false;
						}
					}
				}
			});

	 $(document).on('click', '#make_payment', function(e) {
			$("#make-payment").validate({
				debug: false,
				rules: {
					payment_option: {
						required: true
					},
				},
				submitHandler: function (form) {

			           $.ajax({
			                type: "POST",
			                url: "default/transactions/ajax-call",
			                data: $('#make-payment ').serialize(),
			                success: function (html) {
			                    if (html == 'success') {
			                    	$("#popup").bPopup().close();
			                    	$('#success').text('Transaction successfully updated');
			                        $('#success').fadeIn(1000);
			                        $('#success').fadeOut(3000);
			                        setTimeout("location.reload()", 5000);
								 }
			                }
			            });  //end of $.ajax
		            return false;
		        }
			});
		});


	 $(document).on('click', '#edit_invoice_transaction', function(e) {
			$("#edit-invoice-transaction").validate({
				debug: false,
				rules: {
					date: {
						required: true
					}, 
					description: {
						required: true
					}, 
					amount: {
						required: true,
						number: true
					},
					account: {
						required: true
					},
				},
				submitHandler: function (form) {

			           $.ajax({
			                type: "POST",
			                url: "payments/invoice/ajax-call",
			                data: $('#edit-invoice-transaction').serialize(),
			                success: function (html) {
			                    if (html == 'success') {
			                    	$("#popup").bPopup().close();
			                    	$('#success').text('Transaction successfully updated');
			                        $('#success').fadeIn(1000);
			                        $('#success').fadeOut(3000);
			                        setTimeout("location.reload()", 5000);
								 }
			                }
			            });  //end of $.ajax
		            return false;
		        }
			});
		});


	 $(document).on('click', '#edit_bill_transaction', function(e) {
			$("#edit-bill-transaction").validate({
				debug: false,
				rules: {
					date: {
						required: true
					}, 
					description: {
						required: true
					}, 
					amount: {
						required: true,
						number: true
					},
					account: {
						required: true
					},
				},
				submitHandler: function (form) {

			           $.ajax({
			                type: "POST",
			                url: "payments/bill/ajax-call",
			                data: $('#edit-bill-transaction').serialize(),
			                success: function (html) {
			                    if (html == 'success') {
			                    	$("#popup").bPopup().close();
			                    	$('#success').text('Transaction successfully updated');
			                        $('#success').fadeIn(1000);
			                        $('#success').fadeOut(3000);
			                        setTimeout("location.reload()", 5000);
								 }
			                }
			            });  //end of $.ajax
		            return false;
		        }
			});
		});

	 $("#add-customer").validate({
				rules: {
					name: {
						required: true
					}, 
				}, 
				invalidHandler: function(form, validator) {
					var errors = validator.numberOfInvalids();
					if (errors) {
						var message = errors == 1
						? 'You missed 1 field. It has been highlighted'
						: 'You missed ' + errors + ' fields. They have been highlighted';
						$("#da-ex-val1-error").html(message).show();
					} else {
						$("#da-ex-val1-error").hide();
					}
				}
	  });

	 $("#add-vendor").validate({
				rules: {
					name: {
						required: true
					}, 
				}, 
				invalidHandler: function(form, validator) {
					var errors = validator.numberOfInvalids();
					if (errors) {
						var message = errors == 1
						? 'You missed 1 field. It has been highlighted'
						: 'You missed ' + errors + ' fields. They have been highlighted';
						$("#da-ex-val1-error").html(message).show();
					} else {
						$("#da-ex-val1-error").hide();
					}
				}
	  });


		$("#proxy-setting").validate({
				rules: {
					company: {
						required: true
					}, 
					users: {
						required: true
					}, 
				}, 
				invalidHandler: function(form, validator) {
					var errors = validator.numberOfInvalids();
					if (errors) {
						var message = errors == 1
						? 'You missed 1 field. It has been highlighted'
						: 'You missed ' + errors + ' fields. They have been highlighted';
						$("#da-ex-val1-error").html(message).show();
					} else {
						$("#da-ex-val1-error").hide();
					}
				}
			});


	 
	 	 $("#add-bill").validate({
				rules: {
					vendor: {
						required: true,
					}, 
					date: {
						required: true,
					}, 
					due_date: {
						required: true, 
					}, 
					description: {
						required: true, 
					}, 
					amount: {
						required: true, 
						number: true
					},
				}, 
				invalidHandler: function(form, validator) {
					var errors = validator.numberOfInvalids();
					if (errors) {
						var message = errors == 1
						? 'You missed 1 field. It has been highlighted'
						: 'You missed ' + errors + ' fields. They have been highlighted';
						$("#da-ex-val1-error").html(message).show();
					} else {
						$("#da-ex-val1-error").hide();
					}
				}
			});

			
			$("#da-ex-validate2").validate({
				rules: {
					minl1: {
						required: true, 
						minlength: 5
					}, 
					maxl1: {
						required: true, 
						maxlength: 5
					}, 
					rangel1: {
						required: true, 
						rangelength: [5, 10]
					}, 
					min1: {
						required: true, 
						digits: true, 
						min: 5
					}, 
					max1: {
						required: true, 
						digits: true, 
						max: 5
					}, 
					range1: {
						required: true, 
						digits: true, 
						range: [5, 10]
					}
				}, 
				invalidHandler: function(form, validator) {
					var errors = validator.numberOfInvalids();
					if (errors) {
						var message = errors == 1
						? 'You missed 1 field. It has been highlighted'
						: 'You missed ' + errors + ' fields. They have been highlighted';
						$("#da-ex-val2-error").html(message).show();
					} else {
						$("#da-ex-val2-error").hide();
					}
				}
			});
			
			$("#da-ex-validate3").validate({
				ignore: '.ignore', 
				rules: {
					gender: {
						required: true
					}, 
					sport: {
						required: true
					}, 
					file1: {
						required: true, 
						accept: ['.jpeg']
					}, 
					dd1: {
						required: true
					}, 
					chosen1: {
						required: true
					}, 
					spin1: {
						required: true, 
						min: 5, 
						max: 10
					}
				}
			});
			
			$("#da-ex-validate4").validate({
				rules: {
					email: {
						required: true, 
						email: true
					}, 
					pass2: {
						required: true, 
						minlength: 5
					}, 
					cpass2: {
						required: true, 
						minlength: 5, 
						equalTo: '#pass2'
					}, 
					address: {
						required: "#souvenirs:checked"
					}
				}
			});
		}
	});
}) (jQuery);