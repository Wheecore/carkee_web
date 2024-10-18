$("[name=shipping_type]").on("change", function() {
    $(".flat_rate_shipping_div").hide();

    if ($(this).val() == 'flat_rate') {
        $(".flat_rate_shipping_div").show();
    }

});

function delete_row(em) {
    $(em).closest('.form-group').remove();
}

function pmodels(models) {
    var brand_id = $('#brand_id').val();
    $.ajax({
        url: SITE_URL + "/admin/p-get-car-models",
        type: 'post',
        data: {
            _token: CSRF,
            id: brand_id,
            models: models
        },
        success: function(res) {
            $('#model_id').html(res);
            if (request_year_id) {
                pyears(request_year_id);
                request_year_id = false;
            }
        }
    });
}

function pyears(caryears) {
    var model_id = $('#model_id').val();
    $.ajax({
        url: SITE_URL + "/admin/p-get-car-years",
        type: 'post',
        data: {
            _token: CSRF,
            id: model_id,
            caryears: caryears,
        },
        success: function(res) {
            $('#year_id').html(res);
            if (request_variant_id) {
                car_variants(request_variant_id);
                request_variant_id = false;
            }
        }
    });
}

function car_variants(car_variants) {
    var year_id = $('#year_id').val();
    $.ajax({
        url: SITE_URL + "/admin/p-get-car-variants",
        type: 'post',
        data: {
            _token: CSRF,
            id: year_id,
            car_variants: car_variants,
        },
        success: function(res) {
            $('#variant_id').html(res);
        }
    });
}

function size_subcats_ajax() {
    var cat_id = $('#size_cat_id').val();
    $.ajax({
        url: SITE_URL + "/admin/get-size-sub-cats",
        type: 'get',
        data: {
            id: cat_id
        },
        success: function(res) {
            $('#sub_cat_id').html(res);
        },
        error: function() {
            alert('failed...');

        }
    });
}

function featured_subcats_ajax() {
    var cat_id = $('#featured_cat_id').val();
    $.ajax({
        url: SITE_URL + "/admin/get-featured-sub-cats",
        type: 'get',
        data: {
            id: cat_id
        },
        success: function(res) {
            $('.featured_sub_cat_id').html(res);
        },
        error: function() {
            alert('failed...');

        }
    });
}

function size_childcats_ajax() {
    var cat_id = $('#sub_cat_id').val();
    $.ajax({
        url: SITE_URL + "/admin/get-size-child-cats",
        type: 'get',
        data: {
            id: cat_id
        },
        success: function(res) {
            $('#child_cat_id').html(res);
        },
        error: function() {
            alert('failed...');

        }
    });
}

function tyreSize() {
    var category_id = $('#category_id').val();
    if (category_id == 1) {
        $('.size-card').css('display', 'block');
        $('.service_card').css('display', 'none');
        $('.service_price').css('display', 'none');
        $('.tyre_price').css('display', 'block');
        $('#service_brands').css('display', 'none');
        $('#tyre_brands').css('display', 'flex');
    } else if (category_id == 4) {
        $('.service_card').css('display', 'block');
        $('.size-card').css('display', 'none');
        $('.service_price').css('display', 'block');
        $('.tyre_price').css('display', 'none');
        $('#tyre_brands').css('display', 'none');
        $('#service_brands').css('display', 'flex');
    }
    else if(category_id == 5){
        $('.service_card').css('display', 'none');
        $('.size-card').css('display', 'none');
        $('.service_price').css('display', 'block');
        $('.tyre_price').css('display', 'none');
        $('#tyre_brands').css('display', 'none');
        $('#service_brands').css('display', 'none');
    }
}

function get_sub_child_categories() {
    var category_id = $('#sub_category_id').val();
    $.ajax({
        url: SITE_URL + "/admin/get-sub-child-categories",
        type: 'POST',
        data: {
            _token: CSRF,
            id: category_id
        },
        success: function(res) {
            $('#sub_child_category_id').html(res);
            $("#sub_child_category_id").selectpicker('refresh');
        },
        error: function() {
            alert('failed...');

        }
    });
}

(function() {
    "use strict"
    // Plugin Constructor
    var TagsInput = function(opts) {
        this.options = Object.assign(TagsInput.defaults, opts);
        this.init();
    }

    // Initialize the plugin
    TagsInput.prototype.init = function(opts) {
        this.options = opts ? Object.assign(this.options, opts) : this.options;

        if (this.initialized)
            this.destroy();

        if (!(this.orignal_input = document.getElementById(this.options.selector))) {
            // console.error("tags-input couldn't find an element with the specified ID");
            return this;
        }

        this.arr = [];
        this.wrapper = document.createElement('div');
        this.input = document.createElement('input');
        init(this);
        initEvents(this);

        this.initialized = true;
        return this;
    }

    // Add Tags
    TagsInput.prototype.addTag = function(string) {

        if (this.anyErrors(string))
            return;

        this.arr.push(string);
        var tagInput = this;

        var tag = document.createElement('span');
        tag.className = this.options.tagClass;
        tag.innerText = string;

        var closeIcon = document.createElement('a');
        closeIcon.innerHTML = '&times;';

        // delete the tag when icon is clicked
        closeIcon.addEventListener('click', function(e) {
            e.preventDefault();
            var tag = this.parentNode;

            for (var i = 0; i < tagInput.wrapper.childNodes.length; i++) {
                if (tagInput.wrapper.childNodes[i] == tag)
                    tagInput.deleteTag(tag, i);
            }
        })


        tag.appendChild(closeIcon);
        this.wrapper.insertBefore(tag, this.input);
        this.orignal_input.value = this.arr.join(',');

        return this;
    }

    // Delete Tags
    TagsInput.prototype.deleteTag = function(tag, i) {
        tag.remove();
        this.arr.splice(i, 1);
        this.orignal_input.value = this.arr.join(',');
        return this;
    }

    // Make sure input string have no error with the plugin
    TagsInput.prototype.anyErrors = function(string) {
        if (this.options.max != null && this.arr.length >= this.options.max) {
            console.log('max tags limit reached');
            return true;
        }

        if (!this.options.duplicate && this.arr.indexOf(string) != -1) {
            console.log('duplicate found " ' + string + ' " ')
            return true;
        }

        return false;
    }

    // Add tags programmatically
    TagsInput.prototype.addData = function(array) {
        var plugin = this;

        array.forEach(function(string) {
            plugin.addTag(string);
        })
        return this;
    }

    // Get the Input String
    TagsInput.prototype.getInputString = function() {
        return this.arr.join(',');
    }


    // destroy the plugin
    TagsInput.prototype.destroy = function() {
        this.orignal_input.removeAttribute('hidden');

        delete this.orignal_input;
        var self = this;

        Object.keys(this).forEach(function(key) {
            if (self[key] instanceof HTMLElement)
                self[key].remove();

            if (key != 'options')
                delete self[key];
        });

        this.initialized = false;
    }

    // Private function to initialize the tag input plugin
    function init(tags) {
        tags.wrapper.append(tags.input);
        tags.wrapper.classList.add(tags.options.wrapperClass);
        tags.orignal_input.setAttribute('hidden', 'true');
        tags.orignal_input.parentNode.insertBefore(tags.wrapper, tags.orignal_input);
    }

    // initialize the Events
    function initEvents(tags) {
        tags.wrapper.addEventListener('click', function() {
            tags.input.focus();
        });


        tags.input.addEventListener('keydown', function(e) {
            var str = tags.input.value.trim();

            if (!!(~[9, 13, 188].indexOf(e.keyCode))) {
                e.preventDefault();
                tags.input.value = "";
                if (str != "")
                    tags.addTag(str);
            }

        });
    }


    // Set All the Default Values
    TagsInput.defaults = {
        selector: '',
        wrapperClass: 'tags-input-wrapper',
        tagClass: 'tag',
        max: null,
        duplicate: false
    }

    window.TagsInput = TagsInput;

})();

var tagInput1 = new TagsInput({
    selector: 'tag-input1',
    duplicate: false,
    max: 10
});
tagInput1.addData([]);

function update_label_status_fun(el) {
    if (el.value == 0) {
        $('#update_label_status').val(1)
    } else {
        $('#update_label_status').val(0)
    }

}

function update_return_status_fun(el) {
    if (el.value == 0) {
        $('#update_return_status').val(1)
    } else {
        $('#update_return_status').val(0)
    }

}

function update_shipping_status_fun(el) {
    if (el.value == 0) {
        $('#update_shipping_status').val(1)
    } else {
        $('#update_shipping_status').val(0)
    }
}