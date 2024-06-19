$('[hovertext]').each(function() {
    $(this).attr('data-toggle', 'tooltip');
    $(this).attr('title', $(this).attr('hovertext'));
    $(this).attr('hovertext', null);
    $(this).tooltip();
});