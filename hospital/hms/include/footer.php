<footer style="
  background: linear-gradient(90deg, #2d6cdf, #32a6a8);
  color: #fff;
  padding: 15px 40px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  position: fixed;
  bottom: 0;
  left: 240px;
  right: 0;
  z-index: 100;
">
  <div style="font-weight: 600; letter-spacing: 1px;">
    © <?php echo date('Y'); ?> Hospital Management System
  </div>
  <div>
    <a href="#" id="scrollTopBtn" style="
      background: #fff;
      color: #2d6cdf;
      width: 38px;
      height: 38px;
      border-radius: 50%;
      text-align: center;
      line-height: 38px;
      display: inline-block;
      transition: all 0.3s ease;
      text-decoration: none;
    ">
      <i class="fa fa-arrow-up"></i>
    </a>
  </div>
</footer>

<script>
  document.getElementById("scrollTopBtn").addEventListener("click", function() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
</script>
