(function() {
    // $("#remove_option").hide()
    $("#add_option").click(function () {
        $val_four = $('#3op').attr('id')
        $val_four = parseInt($val_four)
        $val_four = $val_four + 1
        console.log($val_four)

        if(!$('#4class').length){
            $op_four_div = questinnerdom($val_four)
            $add_new = $('#quest_option').append($op_four_div)
            $('#4class label').attr({'for':"#"+$val_four+"op"})
            $('#4class input[type=text]').attr({'id':$val_four+"op",'name':'op_four'})

            $ans_four_div = answinnerdom($val_four)
            $('#quest_answer').append($ans_four_div)
            $('#4answer label').attr({'for':"#answer_"+$val_four})
            $('#4answer input[type=radio]').attr({'id':'answer_'+$val_four,'value':'op_four'})

            $("#remove_option").show()
        }else if(!$('#5class').length){
            $val_four = $val_four + 1
            $op_five_div = questinnerdom($val_four)
            $add_new = $('#quest_option').append($op_five_div)
            $('#5class label.col-form-label').attr({'for':"#"+$val_four+"op"})
            $('#5class input[type=text]').attr({'id':$val_four+"op",'name':'op_five'})

            $ans_four_div = answinnerdom($val_four)
            $('#quest_answer').append($ans_four_div)
            $('#5answer label').attr({'for':"#answer_"+$val_four})
            $('#5answer input[type=radio]').attr({'id':'answer_'+$val_four,'value':'op_five'})

            $('#add_option').hide()
            $("#remove_option").show()
        }else{
            console.log('done adding option')
        }
    });

    $("#remove_option").click(function () {
        if($('#5class').length){
            $('#5class').attr({'id':'','class':''}).html('').hide()
            $('#5answer').attr({'id':'','class':''}).html('').hide()
            $('#add_option').show()
        }else if($('#4class').length){
            $('#4class').attr({'id':'','class':''}).html('').hide()
            $('#4answer').attr({'id':'','class':''}).html('').hide()
            $('#add_option').show()
            $("#remove_option").hide()
        }else{
            console.log('done removing option')
        }
    });

    function questinnerdom(val){
        return '<div class="form-group" id="'+val+'class"><label for="" class="col-form-label">Option '+val+':</label><input type="text" class="form-control" required></div>'
    }

    function answinnerdom(val){
        return '<div class="form-check form-check-inline" id="'+val+'answer"><input class="form-check-input" type="radio" name="answer" required><label for="" class="form-check-label">'+val+'</label></div>'
    }
})();
