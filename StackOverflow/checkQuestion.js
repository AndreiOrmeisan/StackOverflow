const myForm = document.querySelector(".Form");
myForm.addEventListener("submit", async function (e) {
  e.preventDefault();
  const title = document.querySelector(".Title-Box").value;
  const body = document.querySelector(".Body-Box").value;
  const tags = document.querySelector(".Tags-Box").value;
  const data = { title, body, tags };
  let option = {
    method: "POST",
    body: JSON.stringify(data)
  };

  const respons = await fetch("/crudOperations.php", option);
  const info = await respons.json();
  console.log(info);
  CheckQuestion(info);
});

async function Delete(id) {
  const deleteId = id;
  let option = {
    method: "DELETE"
  };
  const respons = await fetch("/crudOperations.php/?" + id, option);
  const info = await respons.json();
  alert(info.Message);
  ComponentDidMount(true);
}

const form = document.querySelector(".Update");
form.addEventListener("submit", async function (e) {
  e.preventDefault();
  const title = document.querySelector(".Update-Title").value;
  const body = document.querySelector(".Update-Body").value;
  const tags = document.querySelector(".Update-Tags").value;
  const id = document.querySelector(".Update-Id").value;
  const data = { title, body, tags, id };
  let option = {
    method: "PUT",
    body: JSON.stringify(data)
  };

  await fetch("/crudOperations.php", option);
  ComponentDidMount(true);
  alert("Update Succes");
  document.querySelector(".modalUpdate").style.display = "none";
  document.querySelector(".Update-Title").value = "";
  document.querySelector(".Update-Body").value = "";
  document.querySelector(".Update-Tags").value = "";
  document.querySelector(".Update-Id").value = "";
});

function Update(id) {
  document.querySelector(".modalUpdate").style.display = "flex";
  document.querySelector(".Update-Id").value = id;
}

function CheckQuestion(info) {
  let Title = document.querySelector(".Title-Box");
  let Body = document.querySelector(".Body-Box");
  let Tags = document.querySelector(".Tags-Box");
  if (info.Status == 200) {
    setTimeout(function () {
      document.querySelector(".modal").style.display = "none";
      document.querySelector(".Loader").style.display = "none";
      ComponentDidMount(true);
      Title.value = "";
      Body.value = "";
      Tags.value = "";
      Title.style.boxShadow = "none";
      Body.style.boxShadow = "none";
      Tags.style.boxShadow = "none";
    }, 1500);
    document.querySelector(".Loader").style.display = "flex";
  } else {
    alert(info.Message);
    if (Title.value == "") {
      Title.style.boxShadow = "1px 1px 1px 2px red";
    }
    if (Body.value == "") {
      Body.style.boxShadow = "1px 1px 1px 2px red";
    }
    if (Tags.value == "") {
      Tags.style.boxShadow = "1px 1px 1px 2px red";
    }
  }
}

function Modal() {
  document.querySelector(".modal").style.display = "flex";
}

function CloseUpdate() {
  document.querySelector(".modalUpdate").style.display = "none";
}
function CloseAsk() {
  document.querySelector(".modal").style.display = "none";
}
