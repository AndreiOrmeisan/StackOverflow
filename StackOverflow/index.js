var pageNumber = 1;
var count = 5;

async function ComponentDidMount(clear) {
  const respons = await fetch("/StackOverflow/crudOperations.php/?page/"+pageNumber+"/count/"+count);
  const posts = await respons.json();

  const table = document.querySelector(".table");
  const post = document.querySelector(".template-post");

  if (clear == true){
    while(table.children.length > 0){
      table.removeChild(table.children[0]);
    }
  }

  posts.forEach(element => {
    tmplPost = post.content.cloneNode(true);
    tmplPost.querySelector(".App-Title").innerHTML = element.Title;
    tmplPost.querySelector(".App-Body").innerHTML = element.Body;
    tmplPost.querySelector(".App-Tag").innerText = element.Tags;
    tmplPost.querySelector(".App-Votes").innerText = element.Score;
    tmplPost.querySelector(".App-Answer").innerText = element.AnswerCount;
    tmplPost.querySelector(".App-View").innerText = element.ViewCount;
    tmplPost.querySelector(".PostDate").innerText = element.CreationDate.date;
    tmplPost.querySelector(".UserName").innerText = element.DisplayName;
    tmplPost.querySelector(".Delete").id = element.Id;
    tmplPost.querySelector(".UpdateButton").id = element.Id;
    table.appendChild(tmplPost);
  });
}

async function TotalQuestions(){
  const respons = await fetch("/StackOverflow/totalQuestions.php");
  const total = await respons.json();

  document.querySelector(".Count").innerText = total;
}

ComponentDidMount(false);

function PreviousPage(){
  if(pageNumber > 1){
    pageNumber--;
    ComponentDidMount(true);
  }
  else{
    pageNumber = 1;
  }
}

function NextPage(){
  pageNumber++;
  ComponentDidMount(true);
}

function TwoPerPage(){
  count = 5;
  ComponentDidMount(true);
}

function ThreePerPage(){
  count = 10;
  ComponentDidMount(true);
}

function FivePerPage(){
  count = 15;
  ComponentDidMount(true);
}
