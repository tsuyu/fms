(function($){
    var PLUGIN_NAME = 'validator';
	
    var Data = {
        defaults: {
            fieldLabel:null,
            className: 'validator_error',
            trigger: 'blur,change',
            format: null,
            invalidEmpty: false,
            onlySpace: false,
            noSpaceFirstLast: false,
            noSpaceAll: false,
            minLength: null,
            maxLength: null,
            minValue: null,
            maxValue: null,
            contains: null,
            notContains: null,
            equals: null,
            notEquals: null,
            checked: null,
            selected:null,
            before: null, // define function that will be called before validation (output will be used for validation); this = field; agrs(field, value);
            after: null, // define function that will be called after default validation (output will be used for error notification (true - valid, false - invalid)); this = field; agrs(field, value, error);
            error: null, // define function that will be called after error occurs (return: true/false - default error code run); this = field; agrs(field, value, error);
            correct: null // define function that will be called after correct state occurs (return: true/false - default correct code run); this = field; agrs(field, value, error);
        },
        formats: {
            email: new RegExp('^[a-z0-9!#$%&\'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$', 'i'),
            ip: /^(\d{1,3}\.){3}\d{1,3}$/,
            date: /^\d{2}[- \/.]\d{2}[- \/.]\d{4}$/,
            datetime: /^\d{2}[- \/.]\d{2}[- \/.]\d{4}\s*?\d{2}[- :.]\d{2}$/,
            phone: /^\d{10,15}$/,
            zipUS: /^(\d{5})(-\d{4})?$/,
            zipCanada: /^[a-z][0-9][a-z]\s*?[0-9][a-z][0-9]$/i,
            creditCard: /^\d{13,16}$/,
            numeric: /^\d+$/,
            decimal: /^[0-9\.,]+$/,
            alphanumeric: /^([a-z]|\d|\s|-|\.|_|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+$/i
        },
        errors: {
            empty: 'Field cannot be empty',
            checked: 'Field should be checked',
            selected: 'Field should be selected',
            email: 'Email field has wrong format',
            ip: 'IP field has wrong format. Example: 111.111.111.111',
            date: 'Date field has wrong format. Example: mm/dd/yyyy',
            datetime: 'Date and time field has wrong format. Example: mm/dd/yyyy hh:mm',
            phone: 'Phone number field has wrong format. Example: 1234567890',
            zipUS: 'US zip code field has wrong format. Example: 10001',
            zipCanada: 'Canada zip code field has wrong format. Example: A6A 6A6',
            creditCard: 'Wrong credit card number field format (digits only)',
            numeric: 'Number can have only digits',
            decimal: 'Number has wrong format',
            alphanumeric: 'Only alphanumeric characters are allowed',
            noSpaceAll: 'Spaces not allowed',
            noSpaceFirstLast: 'Extra spaces are not allowed',
            onlySpace: 'Only spaces are not allowed'
        }
    };
    var PlugIn = {
        initialized: false,
		
        init: function()
        {
            PlugIn.initialized = true;
        },
		
        attach: function(o)
        {
            var $el = $(this);
			
            o = $.extend({}, Data.defaults, o);
			
            // save options
            $el.data(PLUGIN_NAME, o);
	
            // set trigger events
            $.each(o.trigger.split(','), function(i, eventType) {
              eventType += '.' + PLUGIN_NAME;
              $el.unbind(eventType).bind(eventType, function(e) {
                  PlugIn.runValidation(this);
	      });
	    });
        },
        
        //This method will validate input whether the input is only spaces
        onlySpace: function(input){
            var temp = 0;
	
            // This loop will check all the space that detected and add the status if there is a space
            for (var i = 0; i < input.length; i++)
            {
                if (input.charAt(i) == ' ')
                    temp++;
            }

            // If any spaces are detected by previous loop, this method will return false
            if (temp == input.length)
                return false;

            return true;
        },
                
        noSpaceFirstLast: function(input)
        {
            if ((input.charAt(0) == ' ' || input.charAt(input.length - 1) == ' '))
                return true;
            else
            {
                for (var z = 0; z < input.length; z++)
                {
                    if (input.charAt(z) == ' ')
                    {
                        if (input.charAt(z) == input.charAt(z + 1))
                            return true;
                    }
                }
            }

            return false;
        },
                
        noSpaceAll: function(input)
        {
            if(input.match(/\s/g)){
                return true;
            }else{
                return false;
            }
        },
                
        validate: function()
        {
            var error = false;
            $(this).each(function(i, el) {
                if(!PlugIn.runValidation(el)) {
                    error = true;
                }
            });
			
            return !error;
        },
		
        runValidation: function(field)
        {
            $field = $(field);
			
            var er = {
                status: false,
                type: '',
                message: ''
            };
			
            var o = $field.data(PLUGIN_NAME);
			
            // check if validator activated for element
            if(!o) return true;
			
            // get field value to validate
            var v = $field.val();
            // call before function (assign return to value)
            if(o.before) {
                v = o.before.apply($field[0], [$field[0], $field.val()]);
            }
			
            // make sure value is a string
            v += '';
			
            // validate
            if($field.is(':checkbox') || $field.is(':radio')) {
                if(o.checked != null && o.checked != $field.is(':checked')) {
                    er.status = true;
                    er.type = 'checked';
                    er.message = o.fieldLabel+': '+Data.errors.checked;
                }
            }else if($field.is('select')){
				if(o.selected != null && o.selected != $field.is(':selected') && v.length == 0){
                    er.status = true;
                    er.type = 'checked';
                    er.message = o.fieldLabel+': '+Data.errors.selected;
                }
            }
            else {
                if(v.length == 0) {
                    if(o.invalidEmpty == true) {
                        er.status = true;
                        er.type = 'invalidEmpty';
                        er.message = o.fieldLabel+': '+Data.errors.empty;
                    }
                }else if(v.length > 0 && this.onlySpace(v) && o.onlySpace == true) {
                    er.status = true;
                    er.type = 'onlySpace';
                    er.message = o.fieldLabel+': '+Data.errors.onlySpace;
                }
                else if(v.length > 0 && this.noSpaceFirstLast(v) && o.noSpaceFirstLast == true) {
                    er.status = true;
                    er.type = 'noSpaceFirstLast';
                    er.message = o.fieldLabel+': '+Data.errors.noSpaceFirstLast;
                }else if(v.length > 0 && this.noSpaceAll(v) && o.noSpaceAll == true) {
                    er.status = true;
                    er.type = 'noSpaceAll';
                    er.message = o.fieldLabel+': '+Data.errors.noSpaceAll;
                }
                else {
                    if(o.format != null && v.length > 0 && v.search(Data.formats[o.format]) == -1) {
                        er.status = true;
                        er.type = 'format';
                        er.message = o.fieldLabel+': '+Data.errors[o.format];
                    }
                    else if(o.minLength != null && v.length < o.minLength) {
                        er.status = true;
                        er.type = 'minLength';
                        er.message = o.fieldLabel+': '+'Should be at least ' + o.minLength + ' characters long';
                    }
                    else if(o.maxLength != null && v.length > o.maxLength) {
                        er.status = true;
                        er.type = 'maxLength';
                        er.message = o.fieldLabel+': '+'Should be no more than ' + o.maxLength + ' characters';
                    }
                    else if(o.minValue != null && !isNaN(v) && (v * 1 < o.minValue)) {
                        er.status = true;
                        er.type = 'minValue';
                        er.message = o.fieldLabel+': '+'Cannot be less than ' + o.minValue;
                    }
                    else if(o.maxValue != null && !isNaN(v) && (v * 1 > o.maxValue)) {
                        er.status = true;
                        er.type = 'maxValue';
                        er.message = o.fieldLabel+': '+'Cannot be greater than ' + o.maxValue;
                    }
                    else if(o.contains != null && v.search(o.contains) == -1) {
                        er.status = true;
                        er.type = 'contains';
                        er.message = o.fieldLabel+': '+'Should contain "' + o.contains + '"';
                    }
                    else if(o.notContains != null && v.search(o.notContains) != -1) {
                        er.status = true;
                        er.type = 'notContains';
                        er.message = o.fieldLabel+': '+'Should not contain "' + o.notContains + '"';
                    }
                    else if(o.equals != null && v != o.equals) {
                        er.status = true;
                        er.type = 'equals';
                        er.message = o.fieldLabel+': '+'Should be equal to "' + o.equals + '"';
                    }
                    else if(o.notEquals != null && v == o.notEquals) {
                        er.status = true;
                        er.type = 'notEquals';
                        er.message = o.fieldLabel+': '+'Should not be equal to "' + o.notEquals + '"';
                    }
                }
            }
			
            // run after function
            if(o.after) {
                o.after.apply($field[0], [$field[0], $field.val(), er]);
            }
			
            //return status of validation
            if(er.status === true) {
                //add class css
                $field.data('validatorError', true);
                //if validation error
                if(o.error == null || o.error.apply($field[0], [$field[0], $field.val(), er]) !== false) {
                    $field.addClass(o.className);
                }
            }
            else if(er.status === false) {
                //remove class css
                $field.removeData('validatorError');
                //if validation correct 
                if(o.correct == null || o.correct.apply($field[0], [$field[0], $field.val(), er]) !== false) {
                    $field.removeClass(o.className);
                }
            }
			
            return !er.status;
        }
    };
	
    $.fn.validator = function()
    {
        //initialized plugin
        if(!PlugIn.initialized) {
            PlugIn.init();
        }
		
        var output;
		
        if(typeof arguments[0] == 'string') {
            if($.isFunction(PlugIn[arguments[0]])) {
                output = PlugIn[arguments[0]].apply(this, Array.prototype.slice.call(arguments, 1));
            }
        }
        else {
            output = PlugIn.attach.apply(this, [arguments[0]]);
        }
        return (output != undefined ? output : this);
    };
	
    $.validator = Data;
	
})(jQuery);