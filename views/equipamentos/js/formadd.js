//(function($) {
//    $(function() {
//
//        var addFormGroup = function(event) {
//            event.preventDefault();
//
//            var $formGroup = $(this).closest('.form-group');
//            var $multipleFormGroup = $formGroup.closest('.multiple-form-group');
//            var $formGroupClone = $formGroup.clone();
//
//            $(this)
//                    .toggleClass('btn-success btn-add btn-danger btn-remove')
//                    .html('–');
//
//            $formGroupClone.find('input').val('');
//            $formGroupClone.find('.concept').text('Phone');
//            $formGroupClone.insertAfter($formGroup);
//
//            var $lastFormGroupLast = $multipleFormGroup.find('.form-group:last');
//            if ($multipleFormGroup.data('max') <= countFormGroup($multipleFormGroup)) {
//                $lastFormGroupLast.find('.btn-add').attr('disabled', true);
//            }
//        };
//
//        var removeFormGroup = function(event) {
//            event.preventDefault();
//
//            var $formGroup = $(this).closest('.form-group');
//            var $multipleFormGroup = $formGroup.closest('.multiple-form-group');
//
//            var $lastFormGroupLast = $multipleFormGroup.find('.form-group:last');
//            if ($multipleFormGroup.data('max') >= countFormGroup($multipleFormGroup)) {
//                $lastFormGroupLast.find('.btn-add').attr('disabled', false);
//            }
//
//            $formGroup.remove();
//        };
//
//        var selectFormGroup = function(event) {
//            event.preventDefault();
//
//            var $selectGroup = $(this).closest('.input-group-select');
//            var param = $(this).attr("href").replace("#", "");
//            var concept = $(this).text();
//
//            $selectGroup.find('.concept').text(concept);
//            $selectGroup.find('.input-group-select-val').val(param);
//
//        }
//
//        var countFormGroup = function($form) {
//            return $form.find('.form-group').length;
//        };
//
//        $(document).on('click', '.btn-add', addFormGroup);
//        $(document).on('click', '.btn-remove', removeFormGroup);
//        $(document).on('click', '.dropdown-menu a', selectFormGroup);
//
//    });
//})(jQuery);




function adicionar() {
    var ElementoClonado = $(this.parentNode).clone(); //clona o elemento
    var str = $(ElementoClonado).children('input').eq(0).attr('name').split("["); //divide o name por "["
    console.log(str);
    
    var intQtd = parseInt(str[2].split("]")[0]); //resgata o numero entre "[" e "]"
    console.log(intQtd);
    var newName = "produtos[qtd][" + (intQtd + 1) + "]"; //novo valor name somado +1 do original
    ElementoClonado.children('input').eq(0).attr('name', newName); //seta o novo name para o elemento clonado
    $('.wrapper').append(ElementoClonado);
    $('.add').on("click", adicionar);
    $('.remove').on("click", remover);
    $(this).unbind("click");
}

function remover() {
    $(this.parentNode).remove();
}

$(document).ready(function() {
    $('.add').on("click", adicionar);
    $('.remove').on("click", remover);
});