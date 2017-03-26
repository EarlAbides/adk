$(document).ready(function() {

	// Hiker address
	$("#select_country").change(function() {
		var label_select_state = document.getElementById("label_select_state");
		var select_state = document.getElementById("select_state");
		switch (this.value) {
			case "United States":
				label_select_state.innerHTML = "State*";
				select_state.outerHTML = document.getElementById("template_state_us").innerHTML;
				break;
			case "Canada":
				label_select_state.innerHTML = "Province*";
				select_state.outerHTML = document.getElementById("template_state_ca").innerHTML;
				break;
			default:
				label_select_state.innerHTML = "State/Region*";
				select_state.outerHTML = document.getElementById("template_stateregion").innerHTML;
		}
	});

});
