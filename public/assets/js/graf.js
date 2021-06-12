function drawGraph(canvasId, dataArr) {
    const canvas = document.getElementById(canvasId);
    const context = canvas.getContext("2d");

    const GRAPH_TOP = 25;
    const GRAPH_BOTTOM = 375;
    const GRAPH_LEFT = 25;
    const GRAPH_RIGHT = 475;

    const GRAPH_HEIGHT = 350;

    const arrayLen = dataArr.length;

    let largest = 0;
    for (let i = 0; i < arrayLen; i++) {
        if (dataArr[i] > largest) largest = dataArr[i];
    }

    // set font of graf
    context.clearRect(0, 0, 500, 400);
    context.font = "16px Arial";
    context.beginPath();
    context.moveTo(GRAPH_LEFT, GRAPH_BOTTOM);
    context.lineTo(GRAPH_RIGHT, GRAPH_BOTTOM);
    context.lineTo(GRAPH_RIGHT, GRAPH_TOP);
    context.stroke();

    // reference line
    context.beginPath();
    context.strokeStyle = "#BBB";
    context.moveTo(GRAPH_LEFT, GRAPH_TOP);
    context.lineTo(GRAPH_RIGHT, GRAPH_TOP);
    // draw reference value for hours
    context.fillText(largest, GRAPH_RIGHT + 15, GRAPH_TOP);
    context.stroke();

    // draw reference line
    context.beginPath();
    context.moveTo(GRAPH_LEFT, GRAPH_HEIGHT / 4 * 3 + GRAPH_TOP);
    context.lineTo(GRAPH_RIGHT, GRAPH_HEIGHT / 4 * 3 + GRAPH_TOP);
    // draw reference value for hours
    context.fillText(largest / 4, GRAPH_RIGHT + 15, GRAPH_HEIGHT / 4 * 3 + GRAPH_TOP);
    context.stroke();

    // draw reference line
    context.beginPath();
    context.moveTo(GRAPH_LEFT, GRAPH_HEIGHT / 2 + GRAPH_TOP);
    context.lineTo(GRAPH_RIGHT, GRAPH_HEIGHT / 2 + GRAPH_TOP);
    // draw reference value for hours
    context.fillText(largest / 2, GRAPH_RIGHT + 15, GRAPH_HEIGHT / 2 + GRAPH_TOP);
    context.stroke();

    // draw reference x
    context.beginPath();
    context.moveTo(GRAPH_LEFT, GRAPH_HEIGHT / 4 + GRAPH_TOP);
    context.lineTo(GRAPH_RIGHT, GRAPH_HEIGHT / 4 + GRAPH_TOP);
    // draw reference value for y
    context.fillText(largest / 4 * 3, GRAPH_RIGHT + 15, GRAPH_HEIGHT / 4 + GRAPH_TOP);
    context.stroke();

    // draw titles
    context.fillText("Last days", GRAPH_RIGHT / 3, GRAPH_BOTTOM + 50);
    context.fillText("Request", GRAPH_RIGHT + 30, GRAPH_HEIGHT / 2);

    context.beginPath();
    context.lineJoin = "round";
    context.strokeStyle = "black";

    context.moveTo(GRAPH_LEFT, (GRAPH_HEIGHT - dataArr[0] / largest * GRAPH_HEIGHT) + GRAPH_TOP);
    // draw reference value for day of the week
    context.fillText("1", 15, GRAPH_BOTTOM + 25);
    for (let i = 0; i < arrayLen; i++) {
        context.lineTo(GRAPH_RIGHT / arrayLen * i + GRAPH_LEFT,
            (GRAPH_HEIGHT - dataArr[i] / largest * GRAPH_HEIGHT) + GRAPH_TOP);
        // draw reference value for day of the week
        context.fillText(i + 1, GRAPH_RIGHT / arrayLen * i, GRAPH_BOTTOM + 25);
    }
    context.stroke();
}

drawGraph("testCanvas", [0, 0, 100, 0, 115, 99, 20]);