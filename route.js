
const origin = window.location.origin; 
const pathname = window.location.pathname;
const pathSegments = pathname.split('/').filter(segment => segment.length > 0);
const projectDirectoryName = pathSegments[0];
const dynamicBaseUrl = `${origin}/${projectDirectoryName}`;
 


$(document).on('click', '#logout', function () {  
    
    if (confirm("Are you sure you want to logout?")) 
    {
        window.location.href = dynamicBaseUrl +'/logout.php'; 
    }
});