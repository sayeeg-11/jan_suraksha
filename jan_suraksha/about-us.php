<?php
require_once __DIR__ . '/config.php';
?>
<?php include 'header.php'; ?>

<style>
    /* For pages with custom backgrounds, override body background */
body {
    background-color: var(--color-bg) !important;
    background-image: var(--custom-bg, none) !important;
}

/* Update hardcoded colors to use CSS vars */
.text-primary { color: var(--color-primary) !important; }
.btn-primary { 
    background-color: var(--color-primary); 
    border-color: var(--color-primary); 
}
.btn-primary:hover {
    background-color: color-mix(in srgb, var(--color-primary) 90%, black);
    border-color: color-mix(in srgb, var(--color-primary) 80%, black);
}

.section-title{
  text-align:center;
  margin-bottom:15px;
}

.lead-muted{
  max-width:900px;
  text-align:center;
  margin:0 auto 25px auto;
  line-height:1.8;
}

/* Each step block */
.step{
  display:flex;
  align-items:center;
  gap:15px;
  max-width:280px;
}

/* ICON CIRCLE */
.step .icon{
  width:55px;
  height:55px;
  border-radius:22%;
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:20px;
  color:#fff;
  flex-shrink:0;
  box-shadow:0 8px 25px rgba(0,0,0,.15);
}
/* icon colors */
.icon.blue{ background:#2563eb; }
.icon.cyan{ background:#0284c7; }
.icon.green{ background:#059669; }

/* Align steps in a vertical timeline */
  .step-wrapper{
  display:flex;
  flex-direction:column;
  align-items:flex-start;
  gap:0px;
  margin:auto;
  max-width:650px;
}
/* Connector line */
.connector{
  width:2px;
  height:35px;
  background:#ccc;
  margin:0 22px;
}
/* Make text align nicely to the right of icon */
.step{
  width:100%;
  max-width:600px;
}

@media(max-width:768px){
  .step-wrapper{
    max-width:95%;
  }
}
</style>

<main id="page-content" style="padding-top:72px;">
  <div class="container my-5">
        <section>
            <h2 class="section-title">Our Mission</h2>
            <p class="lead-muted">To empower every citizen of India with a secure and efficient platform for voicing concerns and ensuring accountability from public service providers. We are committed to transparency, responsiveness, and upholding the highest standards of integrity in addressing grievances.</p>
        </section>
        <section class="mt-4">
            <h2 class="section-title">How It Works</h2>
            <div class="stepper mt-3">
            <div class="step-wrapper">
            <div class="step">
            <div class="icon blue"><i class="bi bi-file-earmark-text"></i></div>
            <div>
                     <h6>File a Complaint</h6>
                     <p>Submit your complaint with detailed information.</p>
                     </div>
                </div>
                <div class="connector"></div>
                 <div class="step">
            <div class="icon cyan"><i class="bi bi-search"></i></div>
            <div>
                    <h6>Track Your Status</h6>
                    <p>Monitor the progress of your complaint in real-time.</p>
                    </div>
                </div>
                <div class="connector"></div>
                <div class="step">
                    <div class="icon green"><i class="bi bi-check2-circle"></i></div>
                    <div>
                        <h6>Get Resolution</h6>
                        <p>Receive updates and resolution details directly.</p>
                    </div>
                </div>
            </div>
</div>
        </section>

        <section class="privacy">
            <h2 class="section-title">Our Commitment to Privacy</h2>
            <p class="lead-muted">We adhere to the highest standards of data privacy, complying with applicable Indian laws and regulations. Your personal information is protected with robust security measures, ensuring confidentiality and integrity throughout the complaint resolution process.</p>
        </section>
    </div>
</main>

<?php include 'footer.php'; ?>
