import Sidebar from './Sidebar.js'
import Validate from './Validate.js'
import Tabs from './Tabs.js'
import Services from './Services.js'
import Ckeditor from './Ckeditor.js'
import Newsletter from './Newsletter.js'

var App = (function(){

  return {
    init: function() {

      Sidebar.init();
      Validate.init();
      Validate.validateForm('#terminForm');
      Validate.validateForm('#emailForm');
      Validate.validateForm('#passwordForm');
      Validate.validateForm('.productEditForm');
      Validate.validateForm('#userInfoForm');
      Validate.validateForm('#infoForm');
      Validate.validateForm('.kategorieForm');
      Validate.validateForm('#kategorieForm');
      Validate.validateForm('#create_new_service');
      Validate.validateForm('#ereignisForm');
      Validate.validateForm('#sendServiceForm');
      Validate.validateForm('#tarifForm');
      Validate.validateForm('#logoForm');
      Validate.validateForm('#orderForm1');
      Validate.validateForm('#orderForm2');
      Validate.validateForm('#firmDetailsForm');
      Validate.validateForm('#billingBankForm');
      Validate.validateForm('#billingAdressForm');
      Validate.validateForm('#formArticle');
      Validate.validateForm('#assistantForm1');
      Validate.validateForm('#assistantForm2');
      Validate.validateForm('#assistantForm4');
      Validate.validateForm('#assistantForm4-2');
      Services.init();
      Ckeditor.init();
      Tabs.init();
      Newsletter.init();
    }
  }
})();

export default App;