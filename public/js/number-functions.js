"use strict";


const SFNumberFunctions = {
    // Translation js trait

    // Converts any number of any format to a user-selected formated number ...
    _displayNumber: ( number , digits = 0)      => {

        // transform to a valid number first
        number = SFNumberFunctions._parseNumber ( number );
        

        if ( number == 0 ) { return "0,00"; }
        if ( number == null || isNaN( number ) ) { return null; }
        
        // Round to 2 decimal places
        if ( digits == 2 ) { number = Math.round(number * 100) / 100; }
        else if ( digits == 3 ) { number = Math.round(number * 1000) / 1000; }

        const strNumber = String ( number );
        let parts       = strNumber.indexOf(".") >= 0 ? strNumber.split(".") :  number.toFixed (2).split( "." );

        parts[0] = parts[0].replace(",", "."); // Replace thousand separators ..
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Add to every 3 numbers ...

        return strNumber.indexOf(".") >= 0 ? parts.join(',') : parts[0] + ',00' ;
    },

    _displayCurrency: ( number, digits = 0 )    => {

        number =  SFNumberFunctions._displayNumber ( number , digits );
        if ( number == null ) { return number; }

        return number + " " + "€";
        

    },

    _displayPercent : ( number )    => {
        number =  SFNumberFunctions._displayNumber ( number );
        if ( number == null ) { return number; }
        return number + " " + "%";
    },

    _calculateMarkup : ( number1, number2 ) => {
        return SFNumberFunctions._parseNumber ( number1 ) / SFNumberFunctions._parseNumber ( number2 );
    },

    _calculateNumWithMarkup : ( number, markup ) => {
        return SFNumberFunctions._parseNumber ( number ) * SFNumberFunctions._parseNumber ( markup );
    },

    _calculateNumberPercentage : ( number, percentage ) => {
        number = SFNumberFunctions._parseNumber ( number );
        percentage = number * SFNumberFunctions._parseNumber ( percentage ) / 100;
        
        return percentage.toFixed( 2 ) ;
    },

    


    // Whatever happens, this fucntion always returns a valid float number for manipulation...
    _parseNumber: ( number )        => {

        if ( !number  ) return 0.00;
		
		// already a number
		if (typeof number === "number") { return number; }
		
		let str = String(number).trim();
		
		// string but can be converted... ?
        if ( SFNumberFunctions._isValidFloat ( str ) ) { return parseFloat(str); }
       
		// convert to euro format 
		return parseFloat ( str.replace(/\./g, '').replace(',', '.') );
        


    },

    _isValidFloat : ( str )=> {
        return /^-?\d+(\.\d+)?$/.test( str );
    },

    _setInputNumber : ( selector , number) => {
        Inputmask.setValue( selector[0], SFNumberFunctions._displayNumber ( number )  );
    },

    _initInputFormat : () => {

        Inputmask({
            alias: "numeric",
            groupSeparator: ".", // Thousand separator
            autoGroup: true,
            digits: 2,  // Two decimal places
            digitsOptional: false,
            radixPoint: ",", // Use comma as the decimal separator
            placeholder: "0",
            rightAlign: false,
        }).mask(".input-currency");

        Inputmask({
            alias: "numeric",
            groupSeparator: ".", // Thousand separator
            autoGroup: true,
            digits: 2,  // Two decimal places
            digitsOptional: false,
            radixPoint: ",", // Use comma as the decimal separator
            placeholder: "0",
            rightAlign: false,
            min: 0,
            max: 100
        }).mask(".input-percentage");

      

    }

};

