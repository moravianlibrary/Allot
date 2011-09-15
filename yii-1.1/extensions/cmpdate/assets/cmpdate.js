function CStoIsoDate(datum)
{
	try 
	{
		if ((datum != "") && (datum != "0"))
		{
			var aDatum = datum.split(".");
			var den = parseInt(aDatum[0]);
			var mesic = parseInt(aDatum[1]);
			var rok = parseInt(aDatum[2]);
			if (isNaN(den) || isNaN(mesic) || isNaN(rok)) {alert('Chybně zadané datum.'); return '0000-00-00';}
			var unor = 28;
			if ((((rok % 4) == 0 ) && ((rok % 100) != 0)) || ((rok % 400) == 0)) unor = 29;
			var mesice = new Array(0,31,unor,31,30,31,30,31,31,30,31,30,31);
			if (rok<1900 || rok>2100 || mesic<1 || mesic>12 || den<1 || den>mesice[mesic]) {alert('Chybně zadané datum.'); return '0000-00-00';}
			var dat = aDatum[2] + '-' + (aDatum[1].length == 1 ? '0' : '') + aDatum[1] + '-' + (aDatum[0].length == 1 ? '0' : '') + aDatum[0];
		}
		else
		{
			dat = '0000-00-00';
		}
		return dat;
	} catch (e) {alert('Chybně zadané datum.'); return '0000-00-00';}
}
