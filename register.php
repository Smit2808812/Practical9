<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | NovaJoin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="page">
    <section class="intro">
        <div class="brand">nova<span>join</span></div>

        <div class="intro-content">
            <div class="eyebrow">YOUR NEXT CHAPTER</div>
            <h1>Make room for<br>something new.</h1>
            <p>
                Create your account and get started with
                a simple, secure registration experience.
            </p>
        </div>

        <div class="intro-footer">
            SECURE REGISTRATION · PRACTICAL 9
        </div>
    </section>

    <main class="form-side">
        <div class="form-card">
            <div class="mobile-brand">nova<span>join</span></div>

            <div class="form-icon">＋</div>
            <p class="overline">CREATE YOUR PROFILE</p>
            <h2>Join NovaJoin</h2>
            <p class="subtext">Enter your details to create an account.</p>

            <form action="process_registration.php" method="POST">
                <label for="username">Username</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    placeholder="Choose a username"
                    minlength="3"
                    maxlength="100"
                    pattern="[A-Za-z0-9_.-]+"
                    title="Use letters, numbers, dots, underscores or hyphens."
                    autocomplete="username"
                    required
                >

                <label for="email">Email address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="you@example.com"
                    maxlength="150"
                    autocomplete="email"
                    required
                >

                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="At least 8 characters"
                    minlength="8"
                    maxlength="72"
                    autocomplete="new-password"
                    required
                >

                <button type="submit">Create account <span>↗</span></button>
            </form>

            <div class="secure-note">
                <span>✓</span> Your password is securely hashed before storage.
            </div>
        </div>

        <footer class="page-footer">
            NOVAJOIN · WEB DEVELOPMENT FRAMEWORKS
        </footer>
    </main>
</div>

</body>
</html>
