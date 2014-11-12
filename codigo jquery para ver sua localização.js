jQuery.getScript('http://www.geoplugin.net/javascript.gp', function()
{
    $('#getScript-results').html("Your location is: " + geoplugin_countryName() + ",
    " + geoplugin_region() + ", " + geoplugin_city());
});