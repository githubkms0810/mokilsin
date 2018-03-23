function openPopup(uri, target, sizeX, sizeY, scroll){
	var intLeftPos = (screen.width - eval(sizeX)) / 2;
	var intTopPos = (screen.height - eval(sizeY)) / 2 - 20;

	window.open(uri, target, 'toolbar=no,location=no,status=yes,resizable=no,scrollbars=' + scroll + ',width=' + sizeX + ',height=' + sizeY + ',left=' + intLeftPos + ',top=' + intTopPos);
}