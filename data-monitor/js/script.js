$(function() {
    $('.time-select').on('change', function() {
        var lagSelect = $.trim($('.time-select[name="lag"] option:selected').text());
        var aheadSelect = $.trim($('.time-select[name="ahead"] option:selected').text());

        window.history.pushState(null, null, window.location.search.replace(/&lag=[^&]*/, '&lag=' + lagSelect));
        window.history.pushState(null, null, window.location.search.replace(/&ahead=[^&]*/, '&ahead=' + aheadSelect));
        var lagSec = Number(lagSelect)*60*1000;
        var aheadSec = Number(aheadSelect)*60*1000;

        cDate = new Date();

        $('#entities .entity').each(function() {
            $status = $(this).find('.status').first();
            insertTime = $(this).find('.time').first().data('time');
            if(insertTime == "") {
                $status.addClass('no-insert-time');
                return;
            }
            date = new Date(Number(insertTime));

            diff = cDate - date;

            if(diff > 0) {
                if(diff > lagSec) {
                    $status.addClass('lagging');
                } else {
                    $status.removeClass('lagging');

                }
            } else {
                diff = -diff;
                if(diff > aheadSec) {
                    $status.addClass('ahead');
                } else {
                    $status.removeClass('ahead');
                }
            }
        });

        $('.filter-select').first().trigger('change');

    });


    $('.filter-select').on('change', function() {
        filter = $(this).val();
        window.history.pushState(null, null, window.location.search.replace(/&filter=[^&]*/, '&filter=' + filter));

        $('#entities .entity').each(function() {
            $status = $(this).find('.status').first();
            if(filter == 'all') {
                $(this).show();
            } else {
                if(!$status.hasClass(filter)) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            }

        });
    });

    $('.time-select').first().trigger('change');
    $('.filter-select').first().trigger('change');
});
