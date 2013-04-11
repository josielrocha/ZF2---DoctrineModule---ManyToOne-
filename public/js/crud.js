var addOption = function()
{
    var spans = $('span');

    var createButton = function(fieldset)
    {
        var a = $(document.createElement('a'))
                          .attr('href', 'javascript:void(0);')
                          .text('[+] Adicionar')
                          .addClass('btn btn-mini btn-primary mais-um')
                          .on('click', function(){
                                cloneObject($(this));
                                addOption();
                          });

        $(a).insertBefore($(fieldset).children()[0]);
    };

    var cloneObject = function (botao) {

        var parent = $(botao).parent();

        $(parent).children('span').each(function(i, el) {
            if ($(el).attr('data-template')) {
                var template = $(el).attr('data-template');

                var result = /^\<fieldset.*/gi.test(template);
                var tipo = result ? 'fieldset' : 'div';
                var index = $(parent).children(tipo).length;

                $(parent).append(template.replace(/\[__index__\]/gi, '[' + index + ']'));
            }
        });
    };

    // Adicionando o botão
    $(spans).each(function(i, el) {
        if ($(el).attr('data-template')) {
            var parent = $(el).parent();

            var botoes = $(parent).children('.mais-um');
            if (botoes.length === 0) {
                createButton(parent);
            }
        }
    });
};

(function($){
    $(document).ready(function() {
        addOption();
        $('label span').addClass('span2');

        $(document).on('click', '.mais-um', function() {
            $('label span').removeClass('span2').addClass('span2');
        });
    })
})(jQuery);
