//const fs = require('fs');

function WriteToFile(passForm) {

	var name = document.getElementById('name');
	var chest = document.getElementById('chest');
	var waist = document.getElementById('waist');
	var stomach = document.getElementById('stomach');
	var data = name + chest + waist + stomach;

	var fh = fopen("./bodyinfo.txt", 3); // Open the file for writing

	if(fh!=-1) // If the file has been successfully opened
	{
	    fwrite(fh, data); // Write the string to a file
	    fclose(fh); // Close the file
	}
	
	// fs.writeFile('bodyinfo.txt', data, (err) => { 
      
 //    if (err) throw err; 
	// });
}
