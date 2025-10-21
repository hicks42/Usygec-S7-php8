const doughnuts = document.querySelectorAll("[data-array]");
doughnuts.forEach((doughnut) => {
  const dataArray = JSON.parse(doughnut.getAttribute("data-array"));

  let svg = document.createElementNS("http://www.w3.org/2000/svg", "svg"),
    name = "";
  filled = 0;
  svg.setAttribute("width", "200px");
  svg.setAttribute("height", "200px");
  svg.setAttribute("viewBox", "0 0 100 100");

  doughnut.appendChild(svg);

  dataArray.forEach(function (o) {
    //legende
    const legend = document.createElement("div");
    legend.style.color = "#757575";
    legend.insertAdjacentHTML(
      "afterbegin",
      `<span style=\"background-color:${o.color}\">&nbsp;&nbsp;&nbsp;&nbsp;</span> <strong>${o.name}: </strong> ${o.fill}%`
    );
    doughnut.appendChild(legend);

    // cercle
    const circle = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "circle"
      ),
      startAngle = -90,
      radius = 30,
      cx = 50,
      cy = 50,
      strokeWidth = 15,
      dashArray = 2 * Math.PI * radius,
      dashOffset = dashArray - (dashArray * o.fill) / 100,
      angle = (filled * 360) / 100 + startAngle;
    circle.setAttribute("r", radius);
    circle.setAttribute("cx", cx);
    circle.setAttribute("cy", cy);
    circle.setAttribute("fill", "transparent");
    circle.setAttribute("stroke", o.color);
    circle.setAttribute("stroke-width", strokeWidth);
    circle.setAttribute("stroke-dasharray", dashArray);
    circle.setAttribute("stroke-dashoffset", dashOffset);
    circle.setAttribute(
      "transform",
      "rotate(" + angle + " " + cx + " " + cy + ")"
    );
    svg.appendChild(circle);
    name += o.name;
    filled += o.fill;
  });
});
