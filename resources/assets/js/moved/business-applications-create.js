const app = new Vue({
	el: "#app",
	data: {
		businessId: document.getElementById('business_id').value,
		business: {},
		form: new Form({
			business_id: null,
			_1tobaccoOrFood: "1",
			_1applicationType: "1",
			_1toRegisterPlace: true,
			_1toRenewLicense: false,
			_1registerPlace: "1",
			_1renewLicense: "1",
			_1registrationNumber: null,
			_1wantLicenseIndhivehi: true,
			_1wantLicenseInenglish: true,
			_1date:null,
			_2name:null,
			_2idNo:null,
			_2address:null,
			_2phone:null,
			_3name:null,
			_3idNo:null,
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
		this.getBusiness();
	},
	methods: {
		getBusiness() {
			axios
  			.get('/api/businesses/' + this.businessId)
			.then(response => {
				this.business = response.data;
				this.autoFillForm(this.business);
			})
			.catch(errors => console.log(errors));	
		},
		autoFillForm(business) {
			this.form.business_id = this.businessId;
			this.form._1registrationNumber = business.registration_no;
			this.form._2name = business.name_dv;
			this.form._2phone = business.phone;
			this.tryFromlatestApplication(business);
		},
		tryFromlatestApplication(business) {
			if (business.applications.length>0) {
				this.form._1tobaccoOrFood = business.applications[0]._1tobaccoOrFood;
				this.form._1applicationType = business.applications[0]._1applicationType;
				this.form._1toRegisterPlace = business.applications[0]._1toRegisterPlace;
				this.form._1toRenewLicense = business.applications[0]._1toRenewLicense;
				this.form._1registerPlace = business.applications[0]._1registerPlace;
				this.form._1renewLicense = business.applications[0]._1renewLicense;
				this.form._1registrationNumber = business.applications[0]._1registrationNumber;
				this.form._1wantLicenseIndhivehi = business.applications[0]._1wantLicenseIndhivehi;
				this.form._1wantLicenseInenglish = business.applications[0]._1wantLicenseInenglish;
				this.form._1date = business.applications[0]._1date;
				this.form._2name = business.applications[0]._2name;
				this.form._2idNo = business.applications[0]._2idNo;
				this.form._2address = business.applications[0]._2address;
				this.form._2phone = business.applications[0]._2phone;
				this.form._3name = business.applications[0]._3name;
				this.form._3idNo = business.applications[0]._3idNo;
				this.form._3address = business.applications[0]._3address;
				this.form._3phone = business.applications[0]._3phone;
				this.form._4placeName = business.applications[0]._4placeName;
				this.form._4placeAddress = business.applications[0]._4placeAddress;
				this.form._4road = business.applications[0]._4road;
				this.form._4blockNumber = business.applications[0]._4blockNumber;
				this.form._4numberOfServingAreas = business.applications[0]._4numberOfServingAreas;
				this.form._4numberOfChairs = business.applications[0]._4numberOfChairs;
				this.form._5cat11 = business.applications[0]._5cat11;
				this.form._5cat12 = business.applications[0]._5cat12;
				this.form._5cat13 = business.applications[0]._5cat13;
				this.form._5cat14 = business.applications[0]._5cat14;
				this.form._5cat15 = business.applications[0]._5cat15;
				this.form._5cat21 = business.applications[0]._5cat21;
				this.form._5cat31 = business.applications[0]._5cat31;
				this.form._5cat32 = business.applications[0]._5cat32;
				this.form._5cat33 = business.applications[0]._5cat33;
				this.form._5cat41 = business.applications[0]._5cat41;
				this.form._5cat42 = business.applications[0]._5cat42;
				this.form._5cat43 = business.applications[0]._5cat43;
				this.form._5cat51 = business.applications[0]._5cat51;
				this.form._5cat61 = business.applications[0]._5cat61;
				this.form._5cat62 = business.applications[0]._5cat62;
				this.form._5cat71 = business.applications[0]._5cat71;
				this.form._5cat81 = business.applications[0]._5cat81;
				this.form._5cat91 = business.applications[0]._5cat91;
				this.form._5cat101 = business.applications[0]._5cat101;
				this.form._5cat101text = business.applications[0]._5cat101text;
			}
		},
		onSubmit() {
			this.form.post('/applications')
				.then(data => {
					window.location.href= '/applications/' + data.id;
				})
				.catch(errors => console.log(errors));		
		}
	}
});