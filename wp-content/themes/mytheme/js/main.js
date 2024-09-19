if (document.querySelector(".archive-cars")) {
  (function () {
    let obj = {};
    let brandarr = [];
    let brands = document.querySelectorAll(".brand");
    brands.forEach((item) => {
      brandarr.push(item);
    });

    // http://localhost:8888/wp-json/wp/v2/cars?_fields=title,link

    axios
      .get("http://localhost:8888/wp-json/wp/v2/cars") //use the above endpoint instead
      .then((response) => {
        // console.log(response.data);
        kuku(response.data); // Handle success
      })
      .catch((error) => {
        console.error("Error fetching data:", error); // Handle error
      });

    function kuku(arr) {
      //   console.log(item);
      const url = arr.map((item) => {
        return { ul: item.link, tit: item.title.rendered };
      });

      for (let i of brandarr) {
        // console.log(i.textContent);
        url.map((name) => {
          if (name.tit[0] === i.textContent) {
            i.style.display = "block";
            let ele = document.createElement("div");
            ele.innerHTML = `<a href=${name.ul}><div class="imappended">${name.tit}</div></a>`;
            i.append(ele);
          }
        });
      }
    }

    // async function hello() {
    //   const data = await fetch("http://localhost:8888/wp-json/wp/v2/cars");
    //   const res = await data.json();
    //   console.log(res);
    // }
  })();
}
