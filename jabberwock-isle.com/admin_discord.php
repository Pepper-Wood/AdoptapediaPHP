<style>
.discordIcon {
    height: 50px;
    border-radius: 100%;
    background-color: #FFF;
}
</style>
<label>Send Discord Messages</label>
<div class="card">
    <div class="list-group-item">
        <div id="discordUser" class="btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-outline-primary active">
                <input type="radio" name="options" id="bobblehead" autocomplete="off" checked><img class="discordIcon" src="https://orig00.deviantart.net/08ef/f/2018/330/9/a/extracharacter_by_pepper_wood-dcsxymc.png"> Stupid, Sexy Bobblehead
            </label>
            <label class="btn btn-outline-primary">
                <input type="radio" name="options" id="monomi" autocomplete="off"><img class="discordIcon" src="https://orig00.deviantart.net/dd86/f/2018/330/7/3/286258_202497_by_pepper_wood-dcsxys1.png"> Monomi
            </label>
            <label class="btn btn-outline-primary">
                <input type="radio" name="options" id="monokuma" autocomplete="off"><img class="discordIcon" src="https://orig00.deviantart.net/5b4b/f/2018/330/c/c/tumblr_oxflkg6gvd1wpkntco1_250_by_pepper_wood-dcsxyrr.png"> Monokuma
            </label>
            <label class="btn btn-outline-primary">
                <input type="radio" name="options" id="mystery" autocomplete="off"><img class="discordIcon" src="https://orig00.deviantart.net/1bae/f/2018/330/3/8/hey____by_pepper_wood-dcsxyno.png"> ???
            </label>
            <label class="btn btn-outline-primary">
                <input type="radio" name="options" id="tom" autocomplete="off"><img class="discordIcon" src="https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/intermediary/f/01ff5c95-4bc2-4441-be8f-87f5d74105a7/dctgp7n-0513caa3-a2ba-4d21-b7dc-408f7500c269.png"> Tom 1
            </label>
            <label class="btn btn-outline-primary">
                <input type="radio" name="options" id="confusedtom" autocomplete="off"><img class="discordIcon" src="https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/intermediary/f/01ff5c95-4bc2-4441-be8f-87f5d74105a7/dctgp7y-7d54c5b4-35ee-44fb-9b0d-96e20758a897.png"> Tom 2
            </label>
            <label class="btn btn-outline-primary">
                <input type="radio" name="options" id="feduptom" autocomplete="off"><img class="discordIcon" src="https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/intermediary/f/01ff5c95-4bc2-4441-be8f-87f5d74105a7/dctgp77-b2cc1623-0d43-4d83-8cce-1318c377d6cc.png"> Tom 3
            </label>
            <label class="btn btn-outline-primary">
                <input type="radio" name="options" id="fredtom" autocomplete="off"><img class="discordIcon" src="https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/intermediary/f/01ff5c95-4bc2-4441-be8f-87f5d74105a7/dctgp87-c1177870-124b-4313-9571-7c1c8a911d8c.jpg"> Tom 4
            </label>
            <label class="btn btn-outline-primary">
                <input type="radio" name="options" id="memetom" autocomplete="off"><img class="discordIcon" src="https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/intermediary/f/01ff5c95-4bc2-4441-be8f-87f5d74105a7/dctgp8l-58cc6d1f-ef23-4768-b021-8b5deb13094e.png"> Tom 5
            </label>
        </div>
        <div class="form-group" style="margin-top: 1em">
            <select id="discordRoom" class="form-control">
                <option value="Oof">#oof-chat</option>
                <option value="Event">#event-rp</option>
                <option value="Botdom">#botdom</option>
                <option value="Crafting">#crafting-assignments</option>
            </select>
        </div>
        <div class="form-group">
            <label for="discordMessage">Message Text</label>
            <textarea class="form-control" id="discordMessage" rows="3"></textarea>
        </div>
        <button id="sendDiscordMessage" class="btn btn-primary">Send Message</button>
    </div>
</div>

<script>
$("#sendDiscordMessage").click(function() {
    $.post("sendDiscordMessage.php",
        {
            chat: $("#discordRoom").val(),
            user: $('#discordUser label.active input').attr("id"),
            messagetext: $("#discordMessage").val()
        }, function(result) {
        console.log(result);
    });
});
</script>
