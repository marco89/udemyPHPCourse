<?php if (!empty($errors)) : ?>
    <ul>
        <?php // uses a foreach loop to iterate through every array index 
        ?>
        <?php foreach ($errors as $error) : ?>
            <?php // <?= is shorthand for <?php echo 
            ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>



<form method='post'>

    <div>
        <label for='title'>Title</label>
        <!-- uses the result of the $_POST variable that is from the title field of the user input form,
        it only comprises things between the first and second set of quotes -->
        <input type='text' name='title' id='title' placeholder='Article title' value="<?= htmlspecialchars($title); ?>">
    </div>

    <!-- NOTE: if a string containing a quote is inserted in place of the value, such as the string
    "">danger", this opens up the possibility of a cross-site scripting (XSS) attack. This is because
    everything after the second quote is taken as HTML and not as the attribute it was intended to be.
    This means you could potentially place in some malicious HTML code which could lead to a code injection
    which would allow an attacker to harvest cookies or logins. -->         
    
    <!-- the use of the htmlspecialchars() function allows us to display reserved characters like quotes
    or less/greater than symbols without opening ourselves up to XSS attacks. -->

    <div>
        <label for='content'>Content</label>
        <!-- again using the $_POST var for the content field instead of title -->
        <textarea name='content' rows='4' cols='40' id='content' 
                  placeholder='Article content'><?= htmlspecialchars($content); ?></textarea>
    </div>

    <div>
        <label for='published_at'>Publication date and time</label>
        <input type='text' name='published_at' id='published_at' placeholder='YYYY:MM:DD HH:MM:SS' size='21'
               value="<?= htmlspecialchars($published_at); ?>">
    </div>

    <button>Save</button>

</form>