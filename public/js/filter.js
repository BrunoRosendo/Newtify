function replaceArticles() {
  const json = JSON.parse(this.responseText);
  const previousError = select('#filterError');

  if (this.status == 400) {
    const error = createErrorMessage(json.errors);
    error.id = 'filterError';
    error.classList.add('mb-2');

    if (previousError)
        previousError.replaceWith(error);
    else
        select('#filterSection').after(error);

    return;
  }

  if (previousError) previousError.remove();

  const html = json.html;
  const canLoadMore = json.canLoadMore;

  const section = select('#articles');
  while (section.firstChild)
    section.removeChild(section.firstChild);

  section.insertAdjacentHTML('afterbegin', html);

  loadMoreButton = select('#load-more');
  if (loadMoreButton.style.display === "none") {
    if (canLoadMore) loadMoreButton.style.display = "block";
  } else {
    if (!canLoadMore) loadMoreButton.style.display = "none";
  }
}

function filterArticles() {
  const {url, body} = getFilterData();
  sendAjaxRequest('get', url, body, replaceArticles);
}

const getFilterData = (offset = 0) => {
  const type = select('input[name="filterType"]:checked').id;
  let url = `/api/article/filter?type=${type}&offset=${offset}&limit=5`;

  const tags = Array.from(select("#filterTags").selectedOptions)
    .map((elem) => parseInt(elem.value));

  for (let tag of tags)
    url += `&tags[]=${tag}`;

  return {
    url,
    body: null
  };
}
