<?php if (!defined('FLUX_ROOT')) exit; ?>
							</td>
							<td bgcolor="#f5f5f5"></td>
						</tr>

						<tr>
							<td><img src="<?php echo $this->themePath('img/content_bl.gif') ?>" style="display: block" /></td>
							<td bgcolor="#f5f5f5"></td>
							<td><img src="<?php echo $this->themePath('img/content_br.gif') ?>" style="display: block" /></td>
						</tr>
					</table>
				</td>
				<!-- Spacing between content and horizontal end-of-page -->
				<td style="padding: 10px"></td>
			</tr>
			<?php
				$defLogo = $this->themePath('img/nexus-logo.png');
				try {
					if (class_exists('Flux_CMS') && isset($server)) {
						$defLogo = Flux_CMS::get('site_logo_url', $defLogo, $server);
					}
				} catch (Exception $e) {}
			?>
			<tr>
				<td colspan="3"></td>
				<td align="center" style="padding: 10px 0;">
					<img src="<?php echo htmlspecialchars($defLogo) ?>" alt="Server Logo" style="height: 46px; width: auto; background: transparent; object-fit: contain;" />
				</td>
				<td></td>
			</tr>
			<?php if (Flux::config('ShowCopyright')): ?>
			<tr>
				<td colspan="3"></td>
				<td id="copyright">
					<p>
						<strong>Powered by <a href="https://github.com/rathena/FluxCP" target="_blank">FluxCP</a></strong>
					</p>
				</td>
				<td></td>
			</tr>
			<?php endif ?>
			<?php if (Flux::config('ShowRenderDetails')): ?>
			<tr>
				<td colspan="3"></td>
				<td id="info">
					<p>
						Page generated in <strong><?php echo round(microtime(true) - __START__, 5) ?></strong> second(s).
						Number of queries executed: <strong><?php echo (int)Flux::$numberOfQueries ?></strong>.
						<?php if (Flux::config('GzipCompressOutput')): ?>Gzip Compression: <strong>Enabled</strong>.<?php endif ?>
					</p>
				</td>
				<td></td>
			</tr>
			<?php endif ?>

            <tr>
                <td colspan="3"></td>
                <td align="right">
                    <span>Language:
                        <select name="preferred_language" onchange="updatePreferredLanguage(this)">
                            <?php foreach (Flux::getAvailableLanguages() as $lang_key => $lang): ?>
                                <option value="<?php echo htmlspecialchars($lang_key) ?>"<?php if (!empty($_COOKIE['language']) && $_COOKIE['language'] == $lang_key) echo ' selected="selected"' ?>><?php echo htmlspecialchars($lang) ?></option>
                            <?php endforeach ?>
                        </select>
                    </span>
                </td>
                <td></td>
            </tr>
		</table>
	</body>
</html>
