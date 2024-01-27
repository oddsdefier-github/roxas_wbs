function processPenalty() {
    $.ajax({
        url: 'penalty.php',
        type: 'POST',
        data: {
            action: 'processPenalty'
        },
        success: function (response) {
            console.log('Async tasks completed:', response);
        },
        error: function (xhr, status, error) {
            console.error('Error executing async tasks:', error);
        }
    });
}

processPenalty();