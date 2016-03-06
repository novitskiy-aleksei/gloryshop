/**
 * @author Kyle Florence <kyle[dot]florence[at]gmail[dot]com>
 * @website https://github.com/kflorence/jquery-deserialize/
 * @version 1.1.4
 *
 * Dual licensed under the MIT and GPLv2 licenses.
 */
(function( jQuery ) {

var push = Array.prototype.push,
	rcheck = /^(radio|checkbox)$/i,
	rselect = /^(option|select-one|select-multiple)$/i,
	rplus = /\+/g,
	rvalue = /^(hidden|text|search|tel|url|email|password|datetime|date|month|week|time|datetime-local|number|range|color|submit|image|reset|button|textarea)$/i;

jQuery.fn.extend({
	deserialize: function( data, callback ) {
		if ( !this.length || !data ) {
			return this;
		}

		var i, length,
			elements = this[ 0 ].elements || this.find( ":input" ).get(),
			normalized = [];

		if ( !elements ) {
			return this;
		}

		if ( jQuery.isArray( data ) ) {
			normalized = data;

		} else if ( jQuery.isPlainObject( data ) ) {
			var key, value;

			for ( key in data ) {
				jQuery.isArray( value = data[ key ] ) ?
					push.apply( normalized, jQuery.map( value, function( v ) {
						return { name: key, value: v };
					})) : push.call( normalized, { name: key, value: value } );
			}

		} else if ( typeof data === "string" ) {
			var parts;

			data = data.split( "&" );

			for ( i = 0, length = data.length; i < length; i++ ) {
				parts =  data[ i ].split( "=" );
				push.call( normalized, {
					name: decodeURIComponent( parts[ 0 ] ),
					value: decodeURIComponent( parts[ 1 ].replace( rplus, "%20" ) )
				});
			}
		}

		if ( !( length = normalized.length ) ) {
			return this;
		}

		var current, element, item, j, len, property, type;

		for ( i = 0; i < length; i++ ) {
			current = normalized[ i ];

			if ( !( element = elements[ current.name ] ) ) {
				continue;
			}

			type = ( len = element.length ) ? element[ 0 ] : element;
			type = type.type || type.nodeName;
			property = null;

			if ( rvalue.test( type ) ) {
				property = "value";

			} else if ( rcheck.test( type ) ) {
				property = "checked";

			} else if ( rselect.test( type ) ) {
				property = "selected";
			}

			// Handle element group
			if ( len ) {
				for ( j = 0; j < len; j++ ) {
					item = element [ j ];

					if ( item.value == current.value ) {
						item[ property ] = true;
					}
				}

			} else {
				element[ property ] = current.value;
			}
		}

		if ( jQuery.isFunction( callback ) ) {
			callback.call( this );
		}

		return this;
	}
});

})( jQuery );


var timeout_id = 50;
var interval = 1;//
function resetFilter() {
    clearTimeout(timeout_id);
    $("#filter_product_page").val(0);
    timeout_id = setTimeout("getFilter(false)", interval)
}
function updateVal(e, f) {
    var c = String(e).split("?");
    var a = "";
    if (c[1]) {
        var b = c[1].split("&");
        for (var g = 0; g <= (b.length); g++) {
            if (b[g]) {
                var d = b[g].split("=");
                if (d[0] && d[0] == f) {
                    a = d[1]
                }
            }
        }
    }
    return a;
}

// Handles portlet tools & actions 
function handlePortletTools() {
	jQuery('body').on('click', '.portlet > .portlet-title > .tools > a.remove', function (e) {
		e.preventDefault();
		jQuery(this).closest(".portlet").remove();
		
	});

	jQuery('body').on('click', '.portlet > .portlet-title > .tools > a.reload', function (e) {
		e.preventDefault();
		var el = jQuery(this).closest(".portlet").children(".portlet-body");
		var url = jQuery(this).attr("data-url");
		var error = $(this).attr("data-error-display");
	});

	// load ajax data on page init
	$('.portlet .portlet-title a.reload[data-load="true"]').click();

	jQuery('body').on('click', '.portlet > .portlet-title > .tools > .collapse, .portlet .portlet-title > .tools > .expand', function (e) {
		e.preventDefault();
		var el = jQuery(this).closest(".portlet").children(".portlet-body");
		if (jQuery(this).hasClass("collapse")) {
			jQuery(this).removeClass("collapse").addClass("expand");
			el.slideUp(200);
		} else {
			jQuery(this).removeClass("expand").addClass("collapse");
			el.slideDown(200);
		}
		
	});
}
/*Filter*/ 

function parseFilter(b,json) {
	if(json){
        var d = parseInt(json['pmin']);
        var c = Math.ceil(parseFloat(json['pmax']));
        if (b) {
            	$("#price-range").slider("option", {min:d, max:c});			
            if ($("#pmax").val() >= 1) {				
						c = parseInt($("#pmax").val())
						d = parseInt($("#pmin").val());			
            }
           	 $("#price-range").slider("option", {values:[d, c]});
			
            $("#pmin").val(d);

            $("#pmax").val(c);
        }
        if (json['totals_data']) {
            var atts = {};
            $.each(json['totals_data']['attributes'], function(k, v) {
                atts[v.id + "_" + v.text] = v.t;
            });

            $('.a_name').each(function (k, v) {
                var data_attr_id = $(v).attr('data-attr_id');
                if (atts[data_attr_id]) {
                     $('[data-attr_group_id="'+data_attr_id+'"] span').html($('[data-attr_group_id="'+data_attr_id+'"]').attr('data-value')+" <b class=\"badge\">"+atts[data_attr_id]+"</b>");
                     $(v).removeAttr("disabled");
                } else {
                    $('[data-attr_group_id="' + data_attr_id + '"] span').text($('[data-attr_group_id="' + data_attr_id + '"]').attr('data-value'));
                    $(v).attr("disabled", "disabled");
                    $(v).removeAttr('checked');
                    $(v).removeAttr(':selected');
                }
            });

            var h = [];
            $.each(json['totals_data']['manufacturers'], function (f, k) {
                if (k.id) {
                    h[h.length] = k.id;
					if($("#manufacturer_" + k.id).length){
						var j = $("#manufacturer_" + k.id);
						j.removeAttr("disabled");
						if (j.get(0).tagName == "OPTION") {
							j.text($("#m_" + k.id).val() + " (" + k.t + ")")
						} else {
							$('label[for="manufacturer_' + k.id + '"] span').html($("#m_" + k.id).val() + " <b class=\"badge\">" + k.t + "</b>")
						}
					}
                }
            });
            $(".manufacturer_value").each(function (f, k) {
                var j = $(this);
                var l = j.attr("id").match(/manufacturer_(\d+)/);
                if ($.inArray(l[1], h) < 0) {
                    j.attr("disabled", "disabled");
                    if (this.tagName == "OPTION") {
                        j.text($("#m_" + l[1]).val());
                        j.attr("selected", false)
                    } else {
                        $('label[for="manufacturer_' + l[1] + '"] span').text($("#m_" + l[1]).val());
                        j.attr("checked", false)
                    }
                }
            });
            var e = [];
            $.each(json['totals_data']['options'], function (j, k) {
                if (k.id) {
                    e[e.length] = k.id;
                    var f = $("#option_value_" + k.id);
                    if (f.length) {
                        f.removeAttr("disabled");
                        if (f.get(0).tagName == "OPTION") {
                            f.html($("#o_" + k.id).val() + " <b class=\"badge\">" + k.t + "</b>")
                        } else {
                            $('label[for="option_value_' + k.id + '"] span').html($("#o_" + k.id).val() + " <b class=\"badge\">" + k.t + "</b>")
                        }
                    }
                }
            });
            $(".option_value").each(function (j, k) {
                var f = $(this);
                var l = f.attr("id").match(/option_value_(\d+)/);
                if ($.inArray(l[1], e) < 0) {
                    f.attr("disabled", "disabled");
                    if (this.tagName == "OPTION") {
                        f.text($("#o_" + l[1]).val());
                        f.attr("selected", false);
                    } else {
                        $('label[for="option_value_' + l[1] + '"] span').text($("#o_" + l[1]).val());
                        f.attr("checked", false);
                    }
                }
            })
        }
	}
}
/* 
function getFilter(b) {
    var filter_product_query = $("#filter_product_form").serialize();
    var a = filter_product_query.replace(/[^&]+=\.?(?:&|$)/g, "").replace(/&+$/, "");
    if (!b) {
		window.location.hash = a;
    }
    $.ajax({url:"index.php?route=module/ave_product_filter/parse_filter_data",
	type:"POST",
	data:a + (b ? "&getPriceLimits=true" : ""),
	dataType:"json",
	success:function (json) {
    	if (json['product']) {
			html_output='';		
			for (i = 0; i < json['product'].length; i++) {
				item_img = json['product'][i]['thumb'];
				html_output += '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">';
				html_output += '<div class="item_list_block">';
				html_output += '<div class="item_image">';
				html_output += '<a href="'+json['product'][i]['href']+'" data-id="'+json['product'][i]['product_id']+'" class="btn-quick-view" data-text="'+json['text_quickview']+'"><i class="fa fa-eye"></i> </a>';
				html_output += '<div class="item_img">';
						if(json['product'][i]['special']!=false){
				html_output += '<span class="ribbon_label">';
				html_output += '<span class="ribbon_text">'+json['text_sale']+'</span><span class="ribbon_circle sale"></span>';
				html_output += '</span>';
						}
				html_output += '<a href="'+json['product'][i]['href']+'" class="desc">'+json['product'][i]['description']+'</a>';
				html_output += '<img src="'+item_img+'" alt="'+json['product'][i]['name']+'">';
				html_output += '</div>';
				html_output += '</div>';
				html_output += '<div class="item_desc clearfix">';
				html_output += '<div class="title">';
				html_output += '<a href="'+json['product'][i]['href']+'" class="item_product_name">'+json['product'][i]['name']+'</a>';
				html_output += '</div>';
				html_output += '<div class="item-rating">';
				html_output += '<span class="star-'+json['product'][i]['rating']+'"></span>';
				html_output += '</div>';
				html_output += '<span class="item_price_group">';
						if(json['product'][i]['special']!=false){
				html_output += '<ins class="price-new">'+json['product'][i]['special']+'</ins> <del class="price-old">'+json['product'][i]['price']+'</del>';
						} else { 
				html_output += '<ins>'+json['product'][i]['price']+'</ins>';
						   }
						if(json['product'][i]['tax']!=false){	
				html_output += '<span class="price-tax">'+json['text_tax']+' '+json['product'][i]['tax']+'</span>';
						}
				html_output += '</span>';
				html_output += '<div class="button-group btn-cart-group">';
						if(json['btn_cart']==1){
				html_output += '<button type="button" class="btn btn-cart" onclick="cart.add(\''+json['product'][i]['product_id']+'\');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md">'+json['text_cart']+'</span></button>';
						}
						if(json['btn_whistlist']==1){
				html_output += '<button type="button" class="btn btn-wish-list" onclick="wishlist.add(\''+json['product'][i]['product_id']+'\');" data-toggle="tooltip" title="'+json['text_wishlist']+'"><i class="fa fa-heart"></i> </button>';
						}
						if(json['btn_compare']==1){
				html_output += '<button type="button" class="btn btn-compare" onclick="compare.add(\''+json['product'][i]['product_id']+'\');" data-toggle="tooltip" title="'+json['text_compare']+'"><i class="fa fa-exchange"></i> </button>';
						}
				html_output += '</div>';
				html_output += '</div>';
				html_output += '</div>';
				html_output += '</div>';
				
			}//for items
			$("#product-layout").html(html_output);		
			var view='list';
			var storage_ready=false;
			if($("#product-layout").length){
			 storage_ready=true;
			}
			if(storage_ready==true&&localStorage.getItem('display')!=null){
				view = localStorage.getItem('display');
			}
			if (view == 'list') {
				$('#list-view').trigger('click');
			} else {
				$('#grid-view').trigger('click');
				Ave.handleQuickview();
			}
        }
       $(".pagination_row .text-left").html(json['pagination']);
       $(".pagination_row .text-right").html(json['pagination_results']);
	   parseFilter(b,json);
    }})
}
*/
$(document).ready(function () {	
	$(".price_limit").live("change", (function () {
		var b = parseInt($("#pmin").val());
		var a = parseInt($("#pmax").val());
		 $("#price-range").slider("values", [b, a]);		
	
		resetFilter();
	}));
	$("#filter_product_form .filtered").live("change", (function () {
		resetFilter();
	}));
	$("#price-range").slider({range:true, min:0, max:0, values:[0, 0], stop:function (a, b) {
		resetFilter();
	}, slide:function (a, b) {
		$("#pmin").val(b.values[0]);
		$("#pmax").val(b.values[1])
	}});
    $("#pmin").val($("#price-range").slider("values", 0));
    $("#pmax").val($("#price-range").slider("values", 1))
	
    $(".clear_filter").click(function () {
        $("#filter_product_form select").val("");
        $("#filter_product_form :input").each(function () {
            if ($(this).is(":checked")) {
                $(this).attr("checked", false);
            }
        });
        var b = $("#price-range").slider("option", "min");
        var a = $("#price-range").slider("option", "max");
        $("#price-range").slider("option", {values:[b, a]});
        $("#pmin").val(b);
        $("#pmax").val(a);
		localStorage.removeItem('filter_product_query');
        resetFilter();
    });
    $(".pagination a").live("click", (function () {
        var a = $(this).attr("href");
        var b = a.match(/page=(\d+)/);
        $("#filter_product_page").val(b[1]);
		 var json = getFilter(false);
	
        return false;
    }));
    $(".sort select").removeAttr("onchange").change(function () {
        vars = $(this).val().split("&");
        $("#filter_product_sort").val(vars[0]);
        $("#filter_product_order").val(vars[1]);
        resetFilter();
    });
    $(".sort select option").each(function () {
        var d = $(this).val();
        var a = updateVal(d, "sort");
        if (a == "rating") {
            $(this).remove();
        } else {
            $(this).val(a + "&" + updateVal(d, "order"))
        }
    });
    $(".limit select").removeAttr("onchange").change(function () {
        $("#filter_product_limit").val($(this).val());
        resetFilter();
    });
    $(".limit select option").each(function () {
        $(this).val(updateVal($(this).val(), "limit"))
    });
	/*hash*/
   	$("#filter_product_form").deserialize(window.location.hash.substr(1));
	
		 
    if ($(".sort select").length) {
        if ($("#filter_product_sort").val()) {
            $(".sort select").val($("#filter_product_sort").val() + "&" + $("#filter_product_order").val())
        } else {
            vars = $(".sort select").val().split("&");
            $("#filter_product_sort").val(vars[0]);
            $("#filter_product_order").val(vars[1]);
        }
    }
    if ($("#filter_product_limit").length) {
        if ($("#filter_product_limit").val()) {
            $(".limit select").val($("#filter_product_limit").val());
        } else {
            $("#filter_product_limit").val($(".limit select").val());
        }
    }
    var json = getFilter(true);
	handlePortletTools();
});