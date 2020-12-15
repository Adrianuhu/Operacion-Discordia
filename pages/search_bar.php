
<form onsubmit = "return sendNewMessage();" method="POST" id="searchB">
    <div class="searchBar">
        <label for="user"><b>Search for someone</b></label>
        <input id="userTo" type="text" placeholder="Enter Username" name="user" value="">
        <textarea id="textMessage" name="text"></textarea>

        <button type="submit">Send</button>
    </div>

</form>