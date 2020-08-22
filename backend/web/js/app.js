// General
$(function () {
    'use strict';

    $(document).on('collapsed.lte.pushmenu', function () {
        $.ajax({
            type: 'GET',
            url: backendBaseURL + '/site/set-sidebar-menu-state',
            data: {'state': 'closed'}
        });
    });

    $(document).on('shown.lte.pushmenu', function () {
        $.ajax({
            type: 'GET',
            url: backendBaseURL + '/site/set-sidebar-menu-state',
            data: {'state': 'opened'}
        });
    });
});
