
$(document).ready(function() {
    // $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    // });
    $('#search').click(function() {
        $.post("/getusers", { name: "test" },
		function (data, textStatus){
			
		}, "json");
    });
});
