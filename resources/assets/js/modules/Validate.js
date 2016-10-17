import * as ajax from '../ajax.js';

var Validate = (function() {

  /**
   * set global config for validationassistantForm4-2
   */
  function configValidate() {
    $.validator.setDefaults({
      errorClass: "errorFormValid",
      errorElement: "div"
    });
  }

  jQuery.validator.addMethod("checkurl", function(value, element) {
// now check if valid url
    if (value.trim() === '') {
      return true;
    } else {
      return /^http:\/\/|(www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/.test(value);
    }
    }, "Please enter a valid URL."
  );


  jQuery.validator.addMethod("greaterThan",
  function(value, element, params) {

      if (!/Invalid|NaN/.test(new Date(value))) {
          return new Date(value) > new Date($(params).val());
      }

      return isNaN(value) && isNaN($(params).val()) 
          || (Number(value) > Number($(params).val())); 
  },'Must be greater than {0}.');

  // simple date mm/dd/yyyy format
    $.validator.addMethod('validDate', function (value, element) {
        return this.optional(element) ||
          /^\d{2}\/\d{2}\/\d{4}$/.test(value);
    }, 'Please provide a date in the dd/mm/yyyy format');

  /**
   * @param  {[String]} jQuery selector
   * @return {[Object]}
   */
  function validateForm(formId) {
    switch(formId) {

      case '#terminForm':
        $(formId).validate({
          // errorPlacement: function(error, element) {},

          rules: {

            vorname: {
              required: true
            },

            nachname: {
              required: true
            },

            email: {
              required: true,
              email: true
            },

            phone: {
              number: true,
              minlength: 5,
              maxlength: 15
            },

            mobil: {
              number: true,
              minlength: 5,
              maxlength:15
            },
            
          }
        });
        break;

        case '#emailForm':
        $(formId).validate({

          rules: {

            email: {
              required: true,
              email: true
            },

          },

          submitHandler: function (form) {
            let $form = $(form);
            let data = ajax.getFormData($form);
            let path = `${ajax.LOCPATH}/set_email`;

            ajax.sendAjax(data, path)
              .done((res) => {

                if (res) {
                  location.reload();
                } else {
                  this.errors.email = true;
                }
                
              });
             return false;
         }

        });
        break;

        case '#firmDetailsForm':
        $(formId).validate({

          rules: {

            firm_name: {
              required: true
            },

            firm_telnumber: {
              required: true
            },

            street: {
              required: true
            },
            
            post_index: {
              required: true
            },

          }
        });
        break;

        case '#billingBankForm':
      $(formId).validate({

        rules: {



        }
      });
      break;

      case '#assistantForm1':
        $(formId).validate({

          rules: {

            greeting: {
              required: true,
            },

            firstname: {
              required: true,
            },

            lastname: {
              required: true,
            },

            email: {
              required: true,
              email: true
            },

            firmname: {
              required: false,
              checkurl: true
            },

            telnumber: {
              required: true,
              number: true
            },

            mobile: {
              required: false,
              number: true
            },

            gender: {
              required: true,
            },

            birthday: {
              required: true,
            },

          }
        });
        break;

        case '#assistantForm2':
          $(formId).validate({

            rules: {

              firm_name: {
                required: true,
              },

              country: {
                required: true,
              },

              state: {
                required: true,
              },

              city: {
                required: true,
              },

              post_index: {
                required: true,
              },

              street: {
                required: true,
              },

              firmtype: {
                required: true,
              },

            }
          });
          break;

      case '#assistantForm4':
        $(formId).validate({

          rules: {

            country: {
              required: true,
            },

            city: {
              required: true,
            },

            state: {
              required: true
            },

            post_index: {
              required: true,
            },

            street: {
              required: true,
            },

            legal_firm_name: {
              required: true,
            },

          }
        });
        break;

      case '#assistantForm4-2':
        $(formId).validate({

          rules: {

            iban: {
              required: true,
            },

            bic: {
              required: true,
            },

            bank_name: {
              required: true,
            },

            account_owner: {
              required: true,
            },

          }
        });
        break;

        case '#formArticle':
          $(formId).validate({

            rules: {

              subject: {
                required: true,
              },

              form: {
                required: true,
              },

              client_id_test: {
                required: true,
                email: true
              },

              text: {
                required: true,
              }

            }
          });
        break;

        case '#billingAdressForm':
        $(formId).validate({

          rules: {

            firm_name: {
              required: true,
            },

            first_last_name: {
              required: true,
            },

            street: {
              required: true,
            },

            addition_address: {
              required: true,
            },

            post_index: {
              required: true,
              number: true
            }

          }
        });
        break;

        case '#logoForm':
        $(formId).validate({

          rules: {

            slide_name: {
              required: true
            },

          }
        });
        break;

        case '#orderForm1':
        $(formId).validate({

          rules: {

            account_owner: {
              required: true
            },
            account_number: {
              required: true
            },
            bank_code: {
              required: true
            },
            bank_name: {
              required: true
            },
            iban: {
              required: true
            },
            bic: {
              required: true
            },

          }
        });
        break;

        case '#orderForm2':
        $(formId).validate({

          rules: {

            firm_name: {
              required: true
            },
            firm_name: {
              required: true
            },
            first_last_name: {
              required: true
            },
            post_index: {
              required: true
            },
            street: {
              required: true
            }

          }
        });
        break;

        case '#userInfoForm':
        $(formId).validate({

          rules: {

            name: {
              required: true
            },

            phone: {
              required: true,
              number: true,
              minlength: 5,
              maxlength: 15,
            },

            last_name: {
              required: true
            },

            email: {
              required: true,
              email: true
            },

            firstname: {
              required: true
            },

            lastname: {
              required: true
            }

          }
        });
        break;

        case '#sendServiceForm':
        $(formId).validate({

          rules: {

            service_name: {
              required: true
            },

            price: {
              required: true,
              number: true,
              minlength: 1
            },

            duration: {
              required: true,
            }

          }
        });
        break;

        case '#tarifForm':
        $(formId).validate({

          rules: {

            name: {
              required: true
            },

            price: {
              required: true,
              number: true
            },
            duration: {
              required: true,
              number: true
            },
            letters_count: {
              required: true,
              number: true
            },
            employee_count: {
              required: true,
              number: true
            },
            services_count: {
              required: true,
              number: true
            },
            dashboard_count: {
              required: true,
              number: true
            },

          }
        });
        break;


        case '#infoForm':
        $(formId).validate({

          rules: {

            name: {
              required: true
            },

            last_name: {
              required: true
            },

            phone: {
              required: true,
              number: true,
              minlength: 5,
              maxlength: 15
            },

            telnumber: {
              required: true,
              number: true,
              minlength: 5,
              maxlength: 15
            },

            mobile: {
              required: true,
              number: true,
              minlength: 5,
              maxlength: 15
            },

            firstname: {
              required: true
            },

            lastname: {
              required: true
            },

            birthday: {
              required: true,
              validDate: true
            },

            street: {
              required: true
            },

            city: {
              required: true
            },

            state: {
              required: true
            },

            country: {
              required: true
            }

          },

          submitHandler: function (form) {
            let $form = $(form);
            let data = ajax.getFormData($form);
            let path = `${ajax.LOCPATH}/set_personal_info`;
  
            ajax.sendAjax(data, path)
              .done((res) => {
                if (res) {
                  location.reload();
                }
              });
             return false;
         }
        });
        break;


        case '#ereignisForm':
        $(formId).validate({
          errorPlacement: function(error, element) {},

          rules: {

            description: {
              required: true
            },

            date_from: {
              required: true
            },

            date_to: {
              required: true,
              // greaterThan: "#ereignisDateFrom"
            }

          }
        });
        break;


        case '#passwordForm':
        $(formId).validate({

          rules: {

            'old_password': {
              required: true
            },

            'new_password-1' : {
              required: true,
              minlength : 8,
              maxlength: 16
                },
            'new_password-2' : {
              required: true,
              minlength : 8,
              maxlength: 16,
              equalTo : ".newPass1"
            }

          },

          submitHandler: function (form) {
            let $form = $(form);
            let data = ajax.getFormData($form);
            let path = `${ajax.LOCPATH}/set_password`;
            let isEq = !!(data['new_password-1'] === data['new_password-2']);

            ajax.sendAjax(data, path)
              .done((res) => {

                if (!res) {
                  alert('Falsches Passwort');
                  return;
                } else {
                  location.reload();
                }
                
              });
              return false;
         }

        });
        break;

        case '#create_new_service':
        $(formId).validate({

          rules: {

            'create_service_name': {
              required: true,
            },

            'create_service_price' : {
              required: true,
              number: true,
              min: 0
            },
            'create_service_duration' : {
              required: true,
              number: true,
              min: 0
            }

          }
        });
        break;

        case '.productEditForm':
        $(formId).validate({

          rules: {

            'edit_service_name': {
              required: true,
            },

            'edit_service_price' : {
              required: true,
              number: true,
              min: 0
            },
            'edit_service_duration' : {
              required: true,
              number: true,
              min: 0
            }

          }
        });
        break;

        case '#kategorieForm':
        $(formId).validate({

          rules: {

            'create_category_name': {
              required: true,
            },

          }
        });
        break;


        case '.kategorieForm':
        $(formId).validate({

          rules: {

            'create_category_name': {
              required: true,
            },

          }
        });
        break;

    }
  }

  return {
    init: function() {
      configValidate();
    },
    validateForm: validateForm
  }

})();

export default Validate;
