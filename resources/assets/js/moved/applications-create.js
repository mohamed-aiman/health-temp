	const app = new Vue({
		el: "#app",
		data: {
			form: new Form({
				_1tobaccoOrFood: "2",
				_1applicationType: "1",
				_1toRegisterPlace: true,
				_1toRenewLicense: false,
				_1registerPlace: "1",
				_1renewLicense: "1",
				_1registrationNumber: null,
				_1wantLicenseIndhivehi: true,
				_1wantLicenseInenglish: false,
				_1date:null,
				_2name:null,
				_2idNo:'A',
				_2address:null,
				_2phone:null,
				_3name:null,
				_3idNo:'A',
				_3address:null,
				_3phone:null,
				_4placeName:null,
				_4placeAddress:null,
				_4road:null,
				_4blockNumber:null,
				_4numberOfServingAreas:null,
				_4numberOfChairs:null,
				_5cat11:false,
				_5cat12:false,
				_5cat13:false,
				_5cat14:false,
				_5cat15:false,
				_5cat21:false,
				_5cat31:false,
				_5cat32:false,
				_5cat33:false,
				_5cat41:false,
				_5cat42:false,
				_5cat43:false,
				_5cat51:false,
				_5cat61:false,
				_5cat62:false,
				_5cat71:false,
				_5cat81:false,
				_5cat91:false,
				_5cat101:false,
				_5cat101text:null
			})
		},
	  watch: {
	  	'form._1tobaccoOrFood': function() {
	  		if(this.form._1tobaccoOrFood === '1') {
	  			alert('The business should have food license before applying for a tobacco license. after that create a new tobacco application from business profile view.');
	  			this.form._1tobaccoOrFood = '2';
	  		}
	  	},
	  	'form._1wantLicenseIndhivehi': function() {
	  		this.form._1wantLicenseInenglish = !this.form._1wantLicenseIndhivehi;
	  	},
	  	'form._1wantLicenseInenglish': function() {
	  		this.form._1wantLicenseIndhivehi = !this.form._1wantLicenseInenglish;
	  	},
	  	'form._1applicationType': function() {
	  		switch(this.form._1applicationType) {
				    case "1":
				        this.form._1toRegisterPlace = true;
				        this.form._1toRenewLicense = false;
				        break;
				    case "2":
				        this.form._1toRegisterPlace = false;
				        this.form._1toRenewLicense = true;
				        break;
				    default:
				        this.form._1toRegisterPlace = true
				}
		  	}
		},
		mounted() {
		},
		methods: {
			onSubmit() {
				this.form.post('/applications')
					.then(data => {
						window.location.href= '/applications/' + data.id + '/edit';
					})
					.catch(errors => console.log(errors));		
			}
		}
	});