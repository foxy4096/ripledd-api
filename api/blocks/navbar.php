<nav class="navbar" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="/api/sandbox">
      <h1 class="title">Sandbox</h1>
    </a>
  </div>

  <div class="navbar-end">
    <div class="navbar-item">
      <?php if (!is_null(get_authenticated_user())) : ?>
        <div class="buttons">
          <a class="button is-ghost" href="/c/profile.php?u=<?= get_authenticated_user()['user_url']?>">
            <article class="image">
              <img src="/profile/<?= get_authenticated_user()['avatar'] ?>" alt="user-profile-image" style="width: 25px; height: 25px; object-fit: cover; border-radius: 99999px;">
            </article>

          </a>
          <button class="button is-danger" id="logout-button">
            Log out
          </button>
        </div>
        <script>
          document.getElementById('logout-button').addEventListener('click', function() {
            fetch('/api/logout.php').then(response => {
              if (response.ok) {
                window.location.href = './sandbox.php';
              } else {
                alert('Error logging out');
              }
            });
          })
        </script>
      <?php endif ?>
    </div>
  </div>
  </div>
</nav>