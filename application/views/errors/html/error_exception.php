<div style="border:1px solid #990000;padding:20px;margin:20px;font-family:sans-serif;background:#fff;">
    <h3 style="color:#990000;">An uncaught Exception was encountered</h3>
    <p><strong>Type:</strong> <?php echo get_class($exception); ?></p>
    <p><strong>Message:</strong> <?php echo $message; ?></p>
    <p><strong>File:</strong> <?php echo $exception->getFile(); ?></p>
    <p><strong>Line:</strong> <?php echo $exception->getLine(); ?></p>
    <pre style="background:#f4f4f4;padding:10px;"><?php echo $exception->getTraceAsString(); ?></pre>
</div>
