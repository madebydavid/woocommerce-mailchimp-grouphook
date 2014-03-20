jQuery(document).ready(function($) { 

    Blockly.Blocks['text_length'] = {
        init: function() {
            this.setHelpUrl('http://www.w3schools.com/jsref/jsref_length_string.asp');
            this.setColour(160);
            this.appendValueInput('VALUE')
                .setCheck('String')
                .appendField('length');
            this.setOutput(true, 'Number');
            this.setTooltip('Returns number of letters in the provided text.');
        }
    };
    
    Blockly.Blocks['property_check'] = {
        init: function() {
            
            function OddOrEvenDropdown() {
                this.getOptions_ = function() {
                    console.log("custom getOptions_");
                    return Blockly.FieldDropdown.prototype.getOptions_.call(this);
                }
            }
            
            OddOrEvenDropdown.prototype = new Blockly.FieldDropdown([
              ["Odd", "Odd"], 
              ["Even", "Even"]
            ]);
            
            function NumbersDropDown() {
                this.getOptions_ = function() {
                    
                    var originalOptions = Blockly.FieldDropdown.prototype.getOptions_.call(this);
                    var newOptions = [];
                    
                    var oddOrEven = this.sourceBlock_.inputList[0].fieldRow[1].getValue();
                    
                    var i;
                    for (i = 0; i < originalOptions.length; i++) {
                        if (('Odd' == oddOrEven) && (parseInt(originalOptions[i][0]) % 2)) {
                            newOptions.push(originalOptions[i]);
                        } else if (('Even' == oddOrEven) && !((parseInt(originalOptions[i][0]) % 2))) {
                            newOptions.push(originalOptions[i]);
                        }
                    }
                    
                    return newOptions;
                }
                
            }
            
            NumbersDropDown.prototype = new Blockly.FieldDropdown([
             ["1", "1"], 
             ["2", "2"],
             ["3", "3"],
             ["4", "4"],
             ["5", "5"],
            ]);
            
            this.setColour(160);
            this.appendDummyInput()
                .appendTitle("if")
                .appendTitle(new OddOrEvenDropdown(), "ODD")
                .appendTitle(new NumbersDropDown(), "NUM");

            this.setInputsInline(true);
            this.setPreviousStatement(true);
            this.setNextStatement(true);
        }
    }
    
    Blockly.inject(
        document.getElementById('blocklyDiv'),
        {path: './', toolbox: document.getElementById('toolbox')}
    );
});